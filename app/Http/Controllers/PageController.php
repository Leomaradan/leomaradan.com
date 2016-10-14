<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post\Post;
use App\Models\Gallery\Gallery;
use App\Models\TwitterLink;
use App\Models\Link;

class PageController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        return $this->dashboard();
    }
    
    private function sortElem($elem, $timekey, $cat, &$recent, &$old) {
            $elemTime = date_create($elem->$timekey);
            $timestamp = $elemTime->getTimestamp();
            if(date_diff($elemTime, new \DateTime())->days < 16) {
                if(isset($recent[$timestamp])) {
                    $timestamp++;
                }
               $recent[$timestamp] = ['type' => $cat, 'elem' => $elem];
            } else {
                $old[] = ['type' => $cat, 'elem' => $elem];
            }
    }
    
    public function dashboard() 
    {
        /*
         * 10 blog
20 tweet
10 photo
         */
        $posts = Post::published()->take(10)->get();
        $links = Link::orderBy('created_at')->take(20)->get();
        $tweets = TwitterLink::orderBy('created_at')->take(20)->get();
        $images = Gallery::published()->take(5)->get();
        
        $recent = [];
        $old = [];
        //dd($images);
       
        foreach($posts as $post) {
            $this->sortElem($post, 'published_at', 'post', $recent, $old);
        }
        
   
        foreach($tweets as $tweet) {
            $this->sortElem($tweet, 'created_at', 'tweet', $recent, $old);
        }        
        
        foreach($links as $link) {
            $this->sortElem($link, 'created_at', 'link', $recent, $old);
        }              

        foreach($images as $image) {
            $this->sortElem($image, 'created_at', 'image', $recent, $old);
        }     
        
        $seed = key($recent) + 10;
        mt_srand($seed);
        
        $old_shuffle = [];
        $length = count($old);
        for($i=0;$i<$length;$i++){
            $k = mt_rand() . '.' . $i;
            $old_shuffle[$k] = $old[$i];
        }  
        
        $recent = array_reverse($recent);
        ksort($old_shuffle);
        
        $old = $old_shuffle;
        unset($old_shuffle);
        
        $data = array_merge($recent,$old);
        
        return view('frontend.pages.dashboard', compact('data'));
        //dd($old);
        //dd($old_shuffle);
    }
    public function pages($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.index', compact('page'));
    }
}
