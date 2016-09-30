<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\EditMenuRequest;
use App\Http\Requests;

use App\Http\Controllers\Admin\Controller;

use App\Models\Menu;

class AdminMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zones = Menu::getZones();
        return view('backend.menus.index', compact('zones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menu = Menu::create($request->all());

        Session::flash('success', "Le menu a bien été sauvegardé");

        return redirect(route('admin.menu.edit', $menu->zone));
    }

    public function show(Request $request)
    {
        $menus = Menu::getMenu($zone);
        return view('backend.menus.view', compact('menus'));
    }    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit($zone)
    {
        $menus = Menu::getMenu($zone);
        $form = ['method' => 'put', 'url' => route('admin.menus.update', $zone)];
        return view('backend.menus.edit', compact('menus', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::findBySlug($slug)->first();

        $page->update($request->all());

        Session::flash('success', "La page a bien été sauvegardé");

        return redirect(route('admin.pages.edit', $page));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, EditMenuRequest $request)
    {
        $menu = Menu::find($id)->first();
        
        $child = Menu::findByParent($id)->get();
        
        //$menu->delete();
        
        if(count($child) > 0) {
            $ids = $child->pluck('id')->toArray();
            $ids[] = $menu->id;
            //$child->delete();
            return response()->json(['ids' => $ids])->setCallback($request->input('callback'));
        }
 
        return response()->json(['id' => $id])->setCallback($request->input('callback'));
    }
}
