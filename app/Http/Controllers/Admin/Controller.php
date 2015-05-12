<?php namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesCommands;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	public function __construct() {
		parent::__construct();
		$this->middleware('admin');
	}

	public function index()
	{
		return view('admin.index');
	}	

}
