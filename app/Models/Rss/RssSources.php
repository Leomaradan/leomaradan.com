<?php namespace App\Models\Rss;

use Illuminate\Database\Eloquent\Model;

class RssSources extends Model {

	public function getDates()
	{
	    return ['last_update', 'created_at', 'updated_at'];
	}
}
