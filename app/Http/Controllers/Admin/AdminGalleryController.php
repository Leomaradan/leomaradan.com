<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\Controller;

use App\Models\Gallery\Gallery;
use App\Models\Gallery\Image;
use Flickr;

class AdminGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::paginate(10);
        return view('backend.galleries.galleries.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gallery = new Gallery();
        $form = ['url' => route('admin.galleries.store')];
        return view('backend.galleries.galleries.create', compact('gallery', 'form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $gallery = Gallery::create($request->all());

        Session::flash('success', "La galerie a bien été sauvegardé");

        return redirect(route('admin.galleries.edit', $gallery));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gallery = Gallery::find($id);
        return view('backend.galleries.galleries.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gallery = Gallery::find($id);
        $form = ['method' => 'put', 'url' => route('admin.galleries.update', $gallery)];
        return view('backend.galleries.galleries.edit', compact('gallery', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $gallery = Gallery::find($id);

        $gallery->update($request->all());

        Session::flash('success', "La galerie a bien été sauvegardé");

        return redirect(route('admin.galleries.edit', $gallery));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = Gallery::find($id);

        $gallery->delete();

        return redirect(route('admin.galleries.index'));
     
    }
    
    public function getFlickAlbums()
    {
        $photosets = Flickr::listSets(['user_id' => '63204269@N06']);
        
        $flickr = [];
                
        foreach ($photosets->photosets['photoset'] as $photoset) {
            $item = new FlickrGallery([]);
            $item->id = $photoset['id'];
            $item->title = $photoset['title']['_content'];
            $item->description = $photoset['description']['_content'];
            
            //$orderKey = $photoset['date_create'];

            $item->imported = (count(Gallery::findByFlickrId($item->id)->get()) > 0);
            $flickr[$item->id] = $item;
        }
        
        sort($flickr);

        return view('backend.galleries.flickr.index', compact('flickr'));

    }
    
    public function importFlickrAlbum($album, Request $request) {
        //$id = $photosets->photosets['photoset'][1]['id'];
        
  
        $photoset = Flickr::request('flickr.photosets.getInfo', ['photoset_id' => $album, 'user_id' => '63204269@N06'])->photoset;
        $photolist = Flickr::photosForSet($album, '63204269@N06', ['extras' => 'url_c', 'privacy_filter' => '1'])->photoset['photo'];
         
        $gallery = Gallery::firstOrNew(['flickr_id' => $album]);
        $gallery->title = $photoset['title']['_content'];
        $gallery->description = $photoset['description']['_content'];
        $gallery->save();
        
        $order = 1;
        foreach ($photolist as $photo) {
            $item = Image::firstOrNew(['flickr_id' => $photo['id']]);
            $item->image = $photo['url_c'];
            $item->description = (!preg_match("/(\.jpg$|\.png$)/i", $photo['title'])) ? $photo['title'] : '';
            $item->gallery_order = $order;
            $order++;

            $item->gallery_id =  $gallery->id;
            
            $item->save();
            
            if($photo['id'] == $photoset['primary']) {
                $gallery->cover_image = $item->id;
            }
        }
        
        $gallery->save();
        
        return response()->json(['id' => $album])->setCallback($request->input('callback'));
        
        
    }
}

class FlickrGallery extends \ArrayObject { 
    public function __toString()
    {
        if(isset($this->id)) {
            return $this->id;
        }
        return "";
    }

}
