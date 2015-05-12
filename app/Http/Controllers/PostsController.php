<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\Tag;
use App\Models\PostsCategory;

use Illuminate\Http\Request;

class PostsController extends Controller {

	public function index()
	{
		//$posts = Post::published()->get();
		$posts = Post::published()->paginate(10);
		$tags = Tag::get();
		$categories = PostsCategory::get();
		return view('posts.index', compact('posts', 'tags', 'categories'));
	}

	public function show($slug)
	{
		$post = Post::published()->where('slug', $slug)->firstOrFail();
		//$post = Post::where('slug', $slug)->firstOrFail();
		$tags = Tag::get();
		$categories = PostsCategory::get();		
		return view('posts.show', compact('post', 'tags', 'categories'));
	}

	public function search($search)
	{
		//$query = Request::input('q');
		dd($search);
	}
}
