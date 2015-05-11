<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Admin\Controller;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Registrar;

use App\Http\Requests\EditUserRequest;



use App\Models\User;

class AdminUserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::paginate(10);
		return view('admin.user.index', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$user = new User();
		$form = ['url' => route(config('routes.admin._').'.'.config('routes.admin.user').'.store')];
		return view('admin.user.create', compact('user', 'form'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EditUserRequest $request, Registrar $registrar)
	{
		$registrar->create($request->all());
		return redirect(route($this->routeNamePrefix . '.index'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$user = User::find($id);
		$form = ['method' => 'put', 'url' => route(config('routes.admin._').'.'.config('routes.admin.user').'.update', $user)];
		return view('admin.user.edit', compact('user', 'form'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, EditUserRequest $request)
	{
		$user = User::find($id);

		$user->update($request->except(['password']));

		if(!empty($request->get('password'))) {
			$user->password = bcrypt($request->get('password'));
		}
		

		$user->save();

		Session::flash('success', "Le compte a bien été sauvegardé");

		return redirect(route($this->routeNamePrefix . '.edit', $user));

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id, Request $request)
	{
		$user = User::find($id);
		$user->delete();
		return response()->json(['id' => $id])->setCallback($request->input('callback'));
	}

}
