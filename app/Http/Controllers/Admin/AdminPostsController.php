<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\EditPostRequest;
use App\Http\Controllers\Admin\Controller;

use App\Models\Post;
use App\Models\Tag;
use App\Models\PostsCategory;

use Validator;
use Session;
use Input;

use Illuminate\Http\Request;

class AdminPostsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$posts = Post::with('category', 'tags')->paginate(10);
		return view('admin.posts.index', compact('posts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$post = new Post();
		$categories = implode(',', PostsCategory::lists('name', 'id'));
		$form = ['url' => route(config('routes.admin._').'.'.config('routes.admin.blog').'.store'), 'files'=>true];
		return view('admin.posts.create', compact('post', 'categories', 'form'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EditPostRequest $request)
	{
		$post = Post::create($request->all());

		$post->lead_img = $this->uploadImage();	

		$post->save();

		Session::flash('success', "L'article a bien été sauvegardé");

		return redirect(route($this->routeNamePrefix . '.create', $post));		
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function edit($slug)
	{
		$post = Post::findBySlug($slug);
		$categories = implode(',', PostsCategory::lists('name', 'id'));
		$form = ['method' => 'put', 'url' => route(config('routes.admin._').'.'.config('routes.admin.blog').'.update', $post), 'files'=>true];
		return view('admin.posts.edit', compact('post', 'categories', 'form'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function update($slug, EditPostRequest $request)
	{
		$post = Post::findBySlug($slug);

		$post->lead_img = $this->uploadImage();	

		$post->update($request->all());

		Session::flash('success', "L'article a bien été sauvegardé");

		return redirect(route($this->routeNamePrefix . '.edit', $post));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function destroy($slug, Request $request)
	{
		$post = Post::findBySlug($slug);
		$id = $post->id;
		$post->delete();
		return response()->json(['id' => $id])->setCallback($request->input('callback'));
	}

	public function uploadImage() {
	    if (Input::has('image') && Input::file('image')->isValid()) {
	      $destinationPath = 'images/blog/'; // upload path
	      $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
	      $fileName = rand(11111,99999).'.'.$extension; // renameing image
	      Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
	      return $fileName;
	    }	

	    return null;		
	}

}
