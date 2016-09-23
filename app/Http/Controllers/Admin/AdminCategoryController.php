<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EditCategoryRequest;

use App\Http\Requests;
use App\Http\Controllers\Admin\Controller;

use App\Models\Post\Category;
use App\Models\Post\Post;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('backend.posts.categories', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\EditCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditCategoryRequest $request)
    {
        $category = Category::create($request->all());
        return redirect(route('admin.posts.categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $posts = Post::whereHas('category', function($q) use ($slug) {
            $q->where('slug', $slug);
        })->paginate(10);
        $filter = "Articles de la catégorie " . Category::findBySlug($slug)->first()->name;
        return view('backend.posts.index', compact('posts', 'filter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\EditCategoryRequest  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(EditCategoryRequest $request, $slug)
    {
        $category = Category::findBySlug($slug)->first();
        $category->update($request->all());
        return response()->json(['id' => $category->id, 'name' => $category->name, 'slug' => $category->slug])->setCallback($request->input('callback'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @param  App\Http\Requests\EditCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, EditCategoryRequest $request)
    {
        $category = Category::findBySlug($slug)->first();
        $id = $category->id;
        $category->delete();
        return response()->json(['id' => $id])->setCallback($request->input('callback'));
    }
}
