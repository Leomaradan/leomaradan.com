<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Gallery\Gallery;
use App\Models\Gallery\Image;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::published()->paginate(5);
        $galleries_list = [];
        
        foreach($galleries as $gallery) {
            $galleries_list[] = ['type' => 'gallery', 'elem' => $gallery];
        } 
        return view('frontend.galleries.index', ['data' => $galleries_list]);
        
    }
    


    public function show($id)
    {
        $images = $this->getImages($id);
        
        return view('frontend.galleries.show', [
            'gallery' => $images['gallery'],
            'data' => $images['items'], 
            'infiniteScrollUrl' => $images['nextUrl']]);
    }

    
    public function showAPI($id)
    {
        $images = $this->getImages($id);
        $result = ['items' => [], 'nextUrl' => $images['nextUrl']];
        
        foreach($images['items'] as $item) {
            $result['items'][] = [
                'isFancybox' => true, 
                'image' => $item['elem']->thumbnail, 
                'link' => $item['elem']->image, 
                'content' => '<h1>'. $item['elem']->title .'</h1>',
                'title' => $item['elem']->title
            ];
        }

        return response()->json($result);
    }
    
    private function getImages($id) {
        $gallery = Gallery::published()->findById($id)->first();
        $images = $gallery->images()->paginate(10);
        $images_list = [];
        
        foreach($images as $image) {
            $images_list[] = ['type' => 'image', 'elem' => $image];
        } 
        $images->setPath(route('api.gallery.show',$id,false));

        
        return ['gallery' => $gallery, 'items' => $images_list, 'nextUrl' => $images->nextPageUrl()];
    }
}
