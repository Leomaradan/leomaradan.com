<?php namespace App\Models\Rss;

use Illuminate\Database\Eloquent\Model;

class RssArticles extends Model {

	public function getDates()
	{
	    return ['date_article', 'created_at', 'updated_at'];
	}
}
