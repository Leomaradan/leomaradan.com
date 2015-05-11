<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\EditTagRequest;

use App\Models\Post;
use App\Models\Tag;

class AdminTagController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tags = Tag::paginate(10);
		return view('admin.tag.index', compact('tags'));
	}

	public function show($slug)
	{
		$posts = Tag::findBySlug($slug)->posts()->paginate(10);

		/*$posts = Post::whereHas('tag', function($q) use ($slug) {
			$q->where('slug', $slug);
		})->paginate(10);*/
		$filter = "Articles avec le tag " . Tag::findBySlug($slug)->name;
		return view('admin.posts.index', compact('posts', 'filter'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EditTagRequest $request)
	{
		$tag = Tag::create($request->all());
		return redirect(route($this->routeNamePrefix . '.index'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $slug
	 * @return Response
	 */
	public function update($slug, EditTagRequest $request)
	{
		$tag = Tag::findBySlug($slug);

		$tag->update($request->all());
		return response()->json(['id' => $tag->id, 'name' => $tag->name, 'slug' => $tag->slug])->setCallback($request->input('callback'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $slug
	 * @return Response
	 */
	public function destroy($slug, Request $request)
	{

		$tag = Tag::findBySlug($slug);
		$id = $tag->id;
		$tag->delete();
		return response()->json(['id' => $id])->setCallback($request->input('callback'));
	}

}
