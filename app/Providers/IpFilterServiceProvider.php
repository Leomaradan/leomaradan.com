<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class IpFilterServiceProvider extends ServiceProvider {

	protected $defer = true;

	public function boot() {

	}

	public function register() {
		$this->app->singleton('App\IpFilter\IpFilterInterface', function($app)
		{
			return new \App\IpFilter\IpFilterFile($app);
		});		
	}

	public function provides() {
		return ['App\IpFilter\IpFilterInterface'];
	}

}