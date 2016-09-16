<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EditUserRequest;

use App\Http\Requests;
use App\Http\Controllers\Admin\Controller;

use App\Models\User;

use Session;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $form = ['url' => route('admin.users.store')];
        return view('backend.users.create', compact('user', 'form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\EditUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EditUserRequest $request)
    {
        User::create($request->all());
        return redirect(route('admin.users.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $form = ['method' => 'put', 'url' => route('admin.users.update', $user)];
        return view('backend.users.edit', compact('user', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\EditUserRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, $id)
    {
        $user = User::find($id);
        $user->update($request->except(['password']));
        if(!empty($request->get('password'))) {
            $user->password = bcrypt($request->get('password'));
        }
        
        $user->save();
        Session::flash('success', "Le compte a bien été sauvegardé");
        return redirect(route('admin.users.edit', $user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  App\Http\Requests\EditUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, EditUserRequest $request)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['id' => $id])->setCallback($request->input('callback'));
    }
}
