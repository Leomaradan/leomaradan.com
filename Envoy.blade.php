@servers(['web' => 'leo@din.leomaradan.com -p 2246'])

@setup
	$dir = "/home/leo/laravel";
    $dirlinks = ['tmp/cache/models', 'tmp/cache/persistent', 'tmp/cache/views', 'tmp/sessions', 'tests', 'logs'];
    $filelinks = ['config/app.php', '.env'];
    $releases = 3;
    //$remote = false;
    $remote = 'https://github.com/Leomaradan/leomaradan.com.git';

    $shared = $dir . '/shared';
    $current = $dir . '/current';
    $repo = $dir . '/repo';
    $release = $dir . "/releases/" . date('YmdHis');
@endsetup

@macro('deploy')
    createrelease
    composer
    links
    laravel
    linkcurrent
@endmacro

@task('prepare')
    mkdir -p {{ $shared }};
    @if($remote)
        git clone --bare {{ $remote }} {{ $repo }}
    @else
        mkdir -p {{ $repo }};
        cd {{ $repo }};
        git init --bare;
        echo  "{{ $repo }}";
    @endif
@endtask

@task('createrelease')
    mkdir -p {{ $release }};
    @if($remote)
        [ -d {{ $repo }} ] || git clone {{ $remote }} {{ $repo }};
        cd {{ $repo }};
        git remote update;
    @endif
    cd {{ $repo }};
    git archive master | tar -x -C {{ $release }};
    echo "Création de {{ $release }}";
@endtask

@task('composer')
    mkdir -p {{ $shared }}/vendor;
    ln -s {{ $shared }}/vendor {{ $release }}/vendor;
    cd {{ $release }};
    composer update --no-dev --no-progress;
@endtask

@task('links')
    @foreach($dirlinks as $link)
        mkdir -p {{ $shared }}/{{ $link }};
        @if(strpos($link, '/'))
            mkdir -p {{ $release }}/{{ dirname($link) }};
        @endif
        chmod 777 {{ $shared }}/{{ $link }};
        ln -s {{ $shared }}/{{ $link }} {{ $release }}/{{ $link }};
    @endforeach
    @foreach($filelinks as $link)
        ln -s {{ $shared }}/{{ $link }} {{ $release }}/{{ $link }};
    @endforeach
    echo "Liens Finished";
@endtask

@task('linkcurrent')
    rm -f {{ $current }};
    ln -s {{ $release }} {{ $current }};
    ls {{ $dir }}/releases | sort -r | tail -n +{{ $releases + 1 }} | xargs -I{} -r rm -rf {{ $dir }}/releases/{};
    echo "Lien // {{ $current }} --> {{ $release }}";
@endtask

@task('laravel')
    cd {{ $release }};
    chmod 777 {{ $release }}/tmp;
    php artisan migrate
@endtask

@task('rollback')
    rm -f {{ $current }};
    ls {{ $dir }}/releases | tail -n 2 | head -n 1 | xargs -I{} -r ln -s {{ $dir }}/releases/{} {{ $current }};
@endtask