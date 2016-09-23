<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\EditPostRequest;

use App\Http\Requests;
use App\Http\Controllers\Admin\Controller;

use App\Models\Post\Post;
use App\Models\Post\Category;

use Session;

class AdminPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('category', 'tags')->paginate(10);
        return view('backend.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        $categories = implode(',', Category::pluck('name', 'id')->all());
        $form = ['url' => route('admin.posts.store'), 'files'=>true];
        return view('backend.posts.create', compact('post', 'categories', 'form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\EditPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditPostRequest $request)
    {
        $post = Post::create($request->all());
        $post->tags_list = $request->get('tags_list');
        $post->lead_img = $this->uploadImage($request, $post->lead_img);  
        $post->save();
        Session::flash('success', "L'article a bien été sauvegardé");
        return redirect(route('admin.posts.create', $post));  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::findBySlug($slug)->first();
        $categories = implode(',', Category::pluck('name', 'id')->all());
        $form = ['method' => 'put', 'url' => route('admin.posts.update', $post), 'files'=>true];
        return view('backend.posts.edit', compact('post', 'categories', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\EditPostRequest  $request
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function update(EditPostRequest $request, $slug)
    {
        $post = Post::findBySlug($slug)->first();
        $post->tags_list = $request->get('tags_list');
        $post->lead_img = $this->uploadImage($request, $post->lead_img);  
        $post->update($request->all());

        Session::flash('success', "L'article a bien été sauvegardé");

        return redirect(route('admin.posts.edit', $post));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $slug
     * @param  App\Http\Requests\EditPostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, EditPostRequest $request)
    {
        $post = Post::findBySlug($slug)->first();
        $id = $post->id;
        $post->delete();
        return response()->json(['id' => $id])->setCallback($request->input('callback'));
    }

    /**
     * Unpload an image
     *
     * @param  string  $current
     * @return string
     */
    public function uploadImage(EditPostRequest $request, $current = null) {
        if ($request->has('image') && $request->file('image')->isValid()) {
          $destinationPath = 'images/blog/'; // upload path
          $extension = $request->file('image')->getClientOriginalExtension(); // getting image extension
          $fileName = rand(11111,99999).'.'.$extension; // renameing image
          $request->file('image')->move($destinationPath, $fileName); // uploading file to given path
          return $fileName;
        }   
        return $current;        
    }    
}
