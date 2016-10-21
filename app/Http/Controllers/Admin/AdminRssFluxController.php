<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\EditRssFluxRequest;

use App\Http\Requests;
use App\Http\Controllers\Admin\Controller;

use App\Models\Rss\Flux;

class AdminRssFluxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fluxes = Flux::paginate(10);
        return view('backend.rss.index', compact('fluxes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create()
    {
        $flux = new Flux();
        $form = ['url' => route('admin.flux.store')];
        return view('backend.rss.create', compact('flux', 'form'));
    }*/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditRssFluxRequest $request)
    {
        
        //dd($request);
        $flux = Flux::create($request->all());

        return redirect(route('admin.rss.index', $flux));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function edit($id)
    {
        $flux = Flux::where('id', $id)->first();
        $form = ['method' => 'put', 'url' => route('admin.rss.update', $flux)];
        return view('backend.rss.edit', compact('flux', 'form'));
    }*/

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditRssFluxRequest $request, $id)
    {
        $flux = Flux::where('id', $id)->first();

        $flux->update($request->all());

        return response()->json([
            'id' => $flux->id, 
            'title' => $flux->title, 
            'url' => $flux->url,
            'category' => $flux->category
        ])->setCallback($request->input('callback'));        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, EditRssFluxRequest $request)
    {
        $flux = Flux::where('id', $id)->first();

        $flux->articles()->delete();        
        
        $flux->delete();
        return response()->json(['id' => $id])->setCallback($request->input('callback'));
    }
}
