<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use \Input;

use App\Models\Link;

class LinksController extends Controller {

	public function index() {
		return $this->create();
	}

	public function show($key) {
		$link = Link::where('key', $key)->firstOrFail();
		return new RedirectResponse($link->url, 301);
	}

	public function create() {
		return view('links.create');
	}

	public function store() {
		$url = Input::get('url');
		

		$link = Link::where('url', $url)->first();

		if(!$link) {
			$key = $this->getKey();
			$link = Link::create(['url' => $url, 'key' => $key]);
		}
		
		
		return view('links.success', compact("link"));
	}

	private function getKey() {
		$length = 4;
		$cpt = 0;
		$limit = 100000;

		while($limit > 0) {
			$cpt++;
			$uid = $this->generateId($length);

			if($cpt >= 15) {
				$cpt = 0;
				$length++;
			}
			
			$use = Link::where('key', $uid)->first();

			if(!$use) {
				return $uid;
			}

			$limit--;
		}

		throw new Exception("Error Processing Request", 1);
		

	}

	private function generateId($nb) {
		$generate = '';
		for($i = 1; $i<=$nb; $i++) {
			$type = mt_rand(1,3);
			
			if($type==1) {
				$char = mt_rand(48,57);
			} elseif($type==2) {
				$char = mt_rand(65,90);	
			} else {
				$char = mt_rand(97,122);	
			}
			
			$generate .= chr($char);
		}
	
		return $generate;
	}	

}
