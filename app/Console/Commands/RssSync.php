<?php

namespace App\Console\Commands;

use App\Models\Rss\Article;
use App\Models\Rss\Flux;
use Feeds;
use DB;
use Illuminate\Console\Command;

class RssSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:rss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync RSS flux data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fluxes = Flux::all();
        foreach ($fluxes as $flux) {
            $this->parseFlux($flux);
/*
 *   <div class="header">
    <h1><a href="{{ $permalink }}">{{ $title }}</a></h1>
  </div>

  @foreach ($items as $item)
    <div class="item">
      <h2><a href="{{ $item->get_permalink() }}">{{ $item->get_title() }}</a></h2>
      <p>{{ $item->get_description() }}</p>
      <p><small>Posted on {{ $item->get_date('j F Y | g:i a') }}</small></p>
    </div>
  @endforeach
 */
        }
        echo "Done" . PHP_EOL;
    }
    
    public function parseFlux(Flux $flux) {
            $feeds = Feeds::make($flux->url);
            
            $expiration = date('Y-m-d', time() - ($flux->expire_days * 24 * 60 * 60)).' 00:00:00'; 

            echo "Starting sync " . $flux->title . PHP_EOL;
            
            
            /*$data = array(
                'title'     => $feed->get_title(),
                'permalink' => $feed->get_permalink(),
                'items'     => $feed->get_items(),
            );*/
            /*
             *             $table->increments('id');
            $table->integer('flux_id');
            $table->foreign('flux_id')->references('id')->on('rss_flux')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('guid');
            $table->boolean('read')->default(false);
            $table->string('title');
            $table->string('link');
            $table->timestamp('published_at');
            $table->text('description');         
            
            $table->unique(['flux_id','guid']);
             */
            
            foreach($feeds->get_items() as $feed) {
                $article = Article::firstOrNew(['guid' => $feed->get_id(), 'flux_id' => $flux->id]);
                $article->title = $feed->get_title();
                $article->link = $feed->get_permalink();
                $article->published_at = $feed->get_date('Y-m-d H:i:s');
                $article->description = $feed->get_description();
                $article->save();
                echo $feed->get_title() . "save." . PHP_EOL;
            }
            
            echo "End sync " . $flux->title . ". Start purging old articles."  . PHP_EOL;
            
            if($flux->purge_unread) {
                DB::table('rss_items')->where([
                    ['favorite', '=', 'false'],
                    ['published_at', '<=', $expiration],
                ])->delete();  
            } else {
                DB::table('rss_items')->where([
                    ['favorite', '=', 'false'],
                    ['read', '=', 'true'],
                    ['published_at', '<=', $expiration],
                ])->delete();  
            } 
            
            echo "End purging"  . PHP_EOL;
    }
}
