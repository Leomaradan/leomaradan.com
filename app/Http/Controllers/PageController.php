<?php

namespace App\Http\Controllers;

use App\Models\Page;

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
        return $this->pages('index');
    }
    public function pages($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        return view('frontend.pages.index', compact('page'));
    }
}
