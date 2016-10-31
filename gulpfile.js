const elixir = require('laravel-elixir');
const gulp = require('gulp');
const modifyCssUrls = require('gulp-modify-css-urls');
const rename = require('gulp-rename');

require('laravel-elixir-vue');

var Task = elixir.Task;

elixir.config.sourcemaps = false;

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

function bower(mix) {

	/** JavaScript */
	mix
            .scripts(['../bower_components/jquery/dist/jquery.js'//, 
                      //'jquery-migrate.js'
            ], 'public/js/lib/jquery.js')
            .scripts(['../bower_components/bootstrap/dist/js/bootstrap.js', 
                      '../bower_components/bootstrap-combobox/js/bootstrap-combobox.js'], 'public/js/lib/bootstrap.js')
    
            .scripts(['../bower_components/markdown/lib/markdown.js', 
                      '../bower_components/to-markdown/dist/to-markdown.js',
                      '../bower_components/bootstrap-markdown/js/bootstrap-markdown.js'], 'public/js/lib/markdown.js')
                  
            .scripts(['../bower_components/jquery-ui/jquery-ui.js',
                      '../bower_components/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.js',
                      '../bower_components/jqueryui-timepicker-addon/dist/jquery-ui-sliderAccess.js'], 'public/js/lib/jquery-ui.js')
		
            .scripts(['sortable.js', 
                      '../bower_components/masonry/dist/masonry.pkgd.js', 
                      '../bower_components/imagesloaded/imagesloaded.pkgd.js', 
                      '../bower_components/taggingJS/tagging.js',
                      '../bower_components/fancybox/lib/jquery.mousewheel-3.0.6.pack.js',
                      '../bower_components/fancybox/source/jquery.fancybox.js'], 'public/js/lib/jquery.plugins.js')
	;

	/** CSS */
	mix
		.copy('resources/assets/bower_components/bootstrap-markdown/css/bootstrap-markdown.min.css', 'public/css/lib/markdown.css') // déja minifié
		
                .styles(['../bower_components/jquery-ui/themes/ui-lightness/jquery-ui.css', 
                         '../bower_components/jquery-ui-boostrap/css/custom-theme/jquery-ui-1.10.3.custom.css',
                         '../bower_components/jqueryui-timepicker-addon/dist/jquery-ui-timepicker-addon.css'], 'public/css/lib/jquery-ui.css')

		.styles(['../bower_components/taggingJS/example/tag-basic-style.css'], 'public/css/lib/jquery.plugins.css')                 
	;

	/** Other resources */
	mix
		.copy('resources/assets/bower_components/jqueryui-timepicker-addon/dist/i18n/', 'public/js/lib/i18n/')
		.copy('resources/assets/bower_components/jquery-ui/themes/ui-lightness/images/', 'public/css/lib/images/')
		.copy('resources/assets/bower_components/jquery-ui-boostrap/css/custom-theme/images/', 'public/css/lib/images/')
		.copy('resources/assets/bower_components/bootstrap/dist/fonts/*.*', 'public/fonts/')
                .copy('resources/assets/bower_components/fancybox/source/*.png', 'public/img/fancybox/')
                .copy('resources/assets/bower_components/fancybox/source/*.gif', 'public/img/fancybox/')
	;		
}

elixir.extend('editCss', function() {
    
    new Task('modifyUrls', function() {
      return gulp.src('resources/assets/bower_components/fancybox/source/jquery.fancybox.css')
        .pipe(modifyCssUrls({
          modify: function (url) {
            return '../img/fancybox/' + url;
          }
        }))
        .pipe(rename('fancybox.scss'))
        .pipe(gulp.dest('resources/assets/sass/'));
    });    
    
});

elixir(mix => {
    
    mix.editCss();
    
    mix
       .sass(['bootstrap.scss', '../bower_components/bootstrap-combobox/css/bootstrap-combobox.css'], 'public/css/lib/bootstrap.css')
       .sass('backend.scss')
       .sass('style.scss')
       .webpack('lib.js')
       .scripts('backend.js')
       .scripts(['parallax.js','app.js'], 'public/js/app.js')
       .copy('resources/assets/fonts/*.*', 'public/fonts/')
    ;

    bower(mix);
       
});