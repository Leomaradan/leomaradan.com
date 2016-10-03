<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Post\Post;
use App\Models\Post\Tag;
use App\Models\Post\Category;

class PostController extends Controller {

	public function index()
	{
		$posts = Post::published()->paginate(10);
		$all_tags = Tag::published()->get();
		$all_categories = Category::published()->get();
		return view('frontend.posts.index', compact('posts', 'all_tags', 'all_categories'));
	}

	public function show($slug)
	{
		$post = Post::published()->where('slug', $slug)->firstOrFail();
		//$post = Post::where('slug', $slug)->firstOrFail();
		$all_tags = Tag::published()->get();
		$all_categories = Category::published()->get();		
		return view('frontend.posts.show', compact('post', 'all_tags', 'all_categories'));
	}

	public function tags($slug)
	{
		//$posts = Post::published()->get();
		$posts = Tag::findBySlug($slug)->first()->posts()->published()->paginate(10);
		$all_tags = Tag::published()->get();
		$all_categories = Category::published()->get();
		return view('frontend.posts.index', compact('posts', 'all_tags', 'all_categories'));
	}	

	public function category($slug) 
	{
		$posts = Post::whereHas('category', function($q) use ($slug) {
			$q->where('slug', $slug);
		})->published()->paginate(10);		
		$all_tags = Tag::published()->get();
		$all_categories = Category::published()->get();
		return view('frontend.posts.index', compact('posts', 'all_tags', 'all_categories'));		
	}

	public function feed() {

	    // create new feed
	    $feed = \App::make("feed");

	    // cache the feed for 60 minutes (second parameter is optional)
	    $feed->setCache(60, 'leomaradanFeedKey');

	    // check if there is cached feed and build new only if is not
	    if (!$feed->isCached())
	    {
	       // creating rss feed with our most recent 20 posts
	       $posts = Post::published()->orderBy('published_at', 'desc')->take(20)->get();

	       // set your feed's title, description, link, pubdate and language
	       $feed->title = 'Léo Maradan RSS';
	       $feed->description = 'RSS de Léo Maradan';
	       //$feed->logo = 'http://yoursite.tld/logo.jpg';
	       $feed->link = route('blog.feed');
	       $feed->setDateFormat('carbon'); // 'datetime', 'timestamp' or 'carbon'
	       $feed->pubdate = $posts[0]->published_at;
	       $feed->lang = 'fr';
	       $feed->setShortening(false); // true or false
	       //$feed->setTextLimit(100); // maximum length of description text

	       foreach ($posts as $post)
	       {
	           // set item's title, author, url, pubdate, description and content
	           //$feed->add($post->title, $post->author, URL::to($post->slug), $post->created, $post->description, $post->content);
	           $feed->add($post->title, 'Léo Maradan', route('blog.show', $post), $post->published_at, $post->lead, $post->content);
	       }

	    }

	    // first param is the feed format
	    // optional: second param is cache duration (value of 0 turns off caching)
	    // optional: you can set custom cache key with 3rd param as string
	    return $feed->render('atom');

	    // to return your feed as a string set second param to -1
	    // $xml = $feed->render('atom', -1);

	
	}

	/*public function search($search)
	{
		//$query = Request::input('q');
		dd($search);
	}*/
}