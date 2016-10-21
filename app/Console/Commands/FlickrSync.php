<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Gallery\Gallery;
use App\Models\Gallery\Image;
use Flickr;

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
        $photosets = Flickr::listSets(['user_id' => '63204269@N06']);
        
        foreach ($photosets->photosets['photoset'] as $photoset) {

            $this->importFlickrAlbum($photoset['id']);

        }
    }
    
    
    private function importFlickrAlbum($album) {
        //$id = $photosets->photosets['photoset'][1]['id'];
        
  
        $photoset = Flickr::request('flickr.photosets.getInfo', ['photoset_id' => $album, 'user_id' => '63204269@N06'])->photoset;
        $photolist = Flickr::photosForSet($album, '63204269@N06', ['extras' => 'url_c,url_o', 'privacy_filter' => '1'])->photoset['photo'];
         
        $gallery = Gallery::firstOrNew(['flickr_id' => $album]);
        
        $gallery->deactivateTouchWatch();
        
        if(!$gallery->isTouched('title')) {
            $gallery->title = $photoset['title']['_content'];
        }
        
        if(!$gallery->isTouched('description')) {
            $gallery->description = $photoset['description']['_content'];
        }        

        $gallery->save();
 
        $order = 1;
        foreach ($photolist as $photo) {
            $item = Image::firstOrNew(['flickr_id' => $photo['id']]);
            
            $item->image = (isset($photo['url_c'])) ? $photo['url_c'] : $photo['url_o'];

            if(!$item->isTouched('description')) {
                $item->description = (!preg_match("/(\.jpg$|\.png$)/i", $photo['title'])) ? $photo['title'] : '';
            }             
            if(!$item->isTouched('gallery_order')) {
                $item->gallery_order = $order;
            }
            
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
