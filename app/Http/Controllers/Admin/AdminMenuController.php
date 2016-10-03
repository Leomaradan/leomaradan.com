<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\EditMenuRequest;
use App\Http\Requests;

use App\Http\Controllers\Admin\Controller;

use App\Models\Menu;

use Session;
use DB;

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

    public function show($zone)
    {
        $menus = Menu::getMenu($zone);
        return view('backend.menus.show', compact('zone','menus'));
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
        return view('backend.menus.edit', compact('zone','menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $zone)
    {
        $menus = $request->get('menus');

        DB::beginTransaction();
                
        try {
        DB::table('menus')->where('zone', $zone)->delete();
        
        foreach ($menus as $menu) {

            
            $menuParent = Menu::create($this->getMenuItem($zone, $menu));
            
            if(isset($menu['submenu'])) {
                foreach ($menu['submenu'] as $submenu) {
                    Menu::create($this->getMenuItem($zone, $submenu, $menuParent->id)
                            /*[
                        'zone' => $zone,
                        'parent' => $menuParent->id,
                        'type' => ($submenu['type'] !== '') ? $submenu['type'] : null,
                        'title' => $submenu['title'],
                        'link' => $submenu['link'],
                        'order' => $submenu['order']
                    ]*/);
                }
            }
            
           
            
        }
            DB::commit();

            return response()->json(['zone' => $zone, 'message' => 'ok']);
        } catch(Exception $e) {
            DB::rollBack();

        }
        
        return response()->json(['zone' => $zone, 'message' => 'error']);

        
    }
    
    private function getMenuItem($zone, $data, $parent = null) {
           if($data['type'] == 'internalLink' && $data['link'] == '') {
                $data['type'] = ($parent == null) ? null : 'externalLink';
            }
            
            return [
                'zone' => $zone,
                'parent' => $parent,
                'type' => ($data['type'] !== '') ? $data['type'] : null,
                'title' => $data['title'],
                'link' => $data['link'],
                'order' => $data['order']
            ];
            

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
