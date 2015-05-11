<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\EditPostsCategoryRequest;

use App\Models\Post;
use App\Models\PostsCategory;

class AdminCategoryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$categories = PostsCategory::paginate(10);
		return view('admin.category.index', compact('categories'));
	}

	public function show($slug)
	{
		$posts = Post::whereHas('category', function($q) use ($slug) {
			$q->where('slug', $slug);
		})->paginate(10);
		$filter = "Articles de la catégorie " . PostsCategory::findBySlug($slug)->name;
		return view('admin.posts.index', compact('posts', 'filter'));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EditPostsCategoryRequest $request)
	{
		$category = PostsCategory::create($request->all());
		return redirect(route($this->routeNamePrefix . '.index'));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $slug
	 * @return Response
	 */
	public function update($slug, EditPostsCategoryRequest $request)
	{
		$category = PostsCategory::findBySlug($slug);
		$category->update($request->all());
		return response()->json(['id' => $category->id, 'name' => $category->name, 'slug' => $category->slug])->setCallback($request->input('callback'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $slug
	 * @return Response
	 */
	public function destroy($slug, Request $request)
	{
		$category = PostsCategory::findBySlug($slug);
		$id = $category->id;
		$category->delete();
		return response()->json(['id' => $id])->setCallback($request->input('callback'));
	}

}
