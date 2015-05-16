<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Requests\EditPagesRequest;
use App\Http\Controllers\Admin\Controller;

use App\Models\Pages;

use Validator;
use Session;
use Input;

use Illuminate\Http\Request;

class AdminPagesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$pages = Pages::paginate(10);
		return view('admin.pages.index', compact('pages'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$page = new Pages();
		$form = ['url' => route(config('routes.admin._').'.'.config('routes.admin.pages').'.store')];
		return view('admin.pages.create', compact('page', 'form'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EditPagesRequest $request)
	{
		$page = Pages::create($request->all());

		Session::flash('success', "La page a bien été sauvegardé");

		return redirect(route($this->routeNamePrefix . '.create', $page));		
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function edit($slug)
	{
		$page = Pages::findBySlug($slug);
		$form = ['method' => 'put', 'url' => route(config('routes.admin._').'.'.config('routes.admin.pages').'.update', $page)];
		return view('admin.pages.edit', compact('page', 'form'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function update($slug, EditPagesRequest $request)
	{
		$page = Pages::findBySlug($slug);

		$page->update($request->all());

		Session::flash('success', "La page a bien été sauvegardé");

		return redirect(route($this->routeNamePrefix . '.edit', $page));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function destroy($slug, Request $request)
	{
		$page = Pages::findBySlug($slug);
		$id = $page->id;
		$page->delete();
		return response()->json(['id' => $id])->setCallback($request->input('callback'));
	}

}
