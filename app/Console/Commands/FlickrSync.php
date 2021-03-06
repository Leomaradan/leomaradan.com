<?php

namespace App\Console\Commands;

use App\Models\Gallery\Gallery;
use App\Models\Gallery\Image;
use DateTime;
use Flickr;
use Illuminate\Console\Command;

class FlickrSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:flickr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Flickr data';

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
        $photosets = Flickr::listSets(['user_id' => config('flickr.user_id')]);
        
        foreach ($photosets->photosets['photoset'] as $photoset) {

            $this->importFlickrAlbum($photoset['id']);

        }
    }
    
    
    private function importFlickrAlbum($album) {
  
        $photoset = Flickr::request('flickr.photosets.getInfo', ['photoset_id' => $album, 'user_id' => config('flickr.user_id')])->photoset;

        $photolist = Flickr::photosForSet($album, config('flickr.user_id'), ['extras' => 'url_c,url_o,date_taken', 'privacy_filter' => '1'])->photoset['photo'];
         
        $gallery = Gallery::firstOrNew(['flickr_id' => $album]);
        
        $gallery->deactivateTouchWatch();
        
        if(!$gallery->isTouched('title')) {
            $gallery->title = $photoset['title']['_content'];
        }
        
        if(!$gallery->isTouched('description')) {
            $gallery->description = $photoset['description']['_content'];
        }   
        
        $gallery->updated_at = (new DateTime())->setTimestamp($photoset['date_update']);

        $gallery->save();
 
        $order = 1;

        foreach ($photolist as $photo) {
            $item = Image::firstOrNew(['flickr_id' => $photo['id']]);
            
            $item->deactivateTouchWatch();
            
            $item->thumbnail = (isset($photo['url_c'])) ? $photo['url_c'] : null;
            $item->image = $photo['url_o'];

            if(!$item->isTouched('description')) {
                $item->description = (!preg_match("/(\.jpg$|\.png$)/i", $photo['title'])) ? $photo['title'] : '';
            }             
            if(!$item->isTouched('gallery_order')) {
                $item->gallery_order = $order;
            }
            
            $item->updated_at = new DateTime($photo['datetaken']);
            
            $order++;

            if(!$item->isTouched('gallery_id')) {
                $item->gallery_id =  $gallery->id;
            }
            
            $item->save();
            
            if($photo['id'] == $photoset['primary'] && !$gallery->isTouched('cover_image')) {
                $gallery->cover_image = $item->id;
            }
        }
        
        $gallery->save();    
        
    }    
}
