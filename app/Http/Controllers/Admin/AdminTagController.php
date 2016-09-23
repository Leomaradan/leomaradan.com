<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EditTagRequest;

use App\Http\Requests;
use App\Http\Controllers\Admin\Controller;

use App\Models\Post\Post;
use App\Models\Post\Tag;

class AdminTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::paginate(10);
        return view('backend.posts.tags', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\EditTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditTagRequest $request)
    {
        $tag = Tag::create($request->all());
        return redirect(route('admin.tags.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $posts = Tag::findBySlug($slug)->first()->posts()->paginate(10);

        /*$posts = Post::whereHas('tag', function($q) use ($slug) {
            $q->where('slug', $slug);
        })->paginate(10);*/
        $filter = "Articles avec le tag " . Tag::findBySlug($slug)->first()->name;
        return view('backend.posts.index', compact('posts', 'filter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\EditTagRequest  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(EditTagRequest $request, $slug)
    {
        $tag = Tag::findBySlug($slug)->first();

        $tag->update($request->all());
        return response()->json(['id' => $tag->id, 'name' => $tag->name, 'slug' => $tag->slug])->setCallback($request->input('callback'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @param  App\Http\Requests\EditTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(EditTagRequest $request, $slug)
    {
        $tag = Tag::findBySlug($slug)->first();
        $id = $tag->id;

        $tag->posts()->detach();

        $tag->delete();
        return response()->json(['id' => $id])->setCallback($request->input('callback'));
    }
}
