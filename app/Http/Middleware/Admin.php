<?php namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;

class Admin extends Authenticate {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		
		if($this->auth->user()) {
			if(!$this->auth->user()->admin) {
				return response('Unauthorized.', 401);
			}
		}

		return parent::handle($request, $next);

	}

}
