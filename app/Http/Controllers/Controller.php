<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	//protected $routeNamePrefix = "";

	public function __construct() {
		
		/*$controller = $this;
		$this->beforeFilter(function() use ($controller) {
			$routeName = $controller->getRouter()->currentRouteName();
			if($routeName) {
				$pos = strrpos($routeName, '.');
				if($pos !== false) {
					$controller->routeNamePrefix = substr($routeName, 0, $pos);
				}
			}
		});*/
	}    
}
