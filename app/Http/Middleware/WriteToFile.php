<?php namespace App\Http\Middleware;

use Closure;
use Route;
use File;

class WriteToFile {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$response = $next($request);
		$name = Route::currentRouteName();
		if($name) {
			File::put($name . '.html', $response);
		}

		return $response;
	}

}
