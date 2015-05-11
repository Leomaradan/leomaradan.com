<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	protected $routeNamePrefix = "";

	public function __construct() {
		
		$controller = $this;

		$this->beforeFilter(function() use ($controller) {
			$routeName = $controller->getRouter()->currentRouteName();

			if($routeName) {
				$pos = strrpos($routeName, '.');

				if($pos !== false) {
					$controller->routeNamePrefix = substr($routeName, 0, $pos);
				}
			}
		});
	}

}
