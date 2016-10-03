<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\EditPageRequest;
use App\Http\Controllers\Admin\Controller;
use App\Models\Page;
use Session;

class AdminPageController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $pages = Page::paginate(10);
        return view('backend.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $page = new Page();
        $form = ['url' => route('admin.pages.store')];
        return view('backend.pages.create', compact('page', 'form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\EditPageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditPageRequest $request) {
        $page = Page::create($request->all());

        Session::flash('success', "La page a bien été sauvegardé");

        return redirect(route('admin.pages.edit', $page));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function edit($slug) {
        $page = Page::findBySlug($slug)->first();
        $form = ['method' => 'put', 'url' => route('admin.pages.update', $page)];
        return view('backend.pages.edit', compact('page', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param App\Http\Requests\EditPageRequest  $request
     * @param string $slug
     * @return \Illuminate\Http\Response
     */
    public function update(EditPageRequest $request, $slug) {
        $page = Page::findBySlug($slug)->first();

        $page->update($request->all());

        Session::flash('success', "La page a bien été sauvegardé");

        return redirect(route('admin.pages.edit', $page));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $slug
     * @param App\Http\Requests\EditPageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug, EditPageRequest $request) {
        $page = Page::findBySlug($slug)->first();
        $id = $page->id;
        $page->delete();
        return response()->json(['id' => $id])->setCallback($request->input('callback'));
    }

}
