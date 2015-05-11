<?php

namespace App\IpFilter;

use Illuminate\Support\Facades\Facade;

class IpFilterFacade extends Facade {

	protected static function getFacadeAccessor() {
		return 'App\IpFilter\IpFilterInterface';
	}

}