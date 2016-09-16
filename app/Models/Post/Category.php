<?php

namespace App\Models\Post;

use App\Models\SlugTemplate;

class Category extends SlugTemplate
{

	protected $fillable = ['name', 'slug'];

	public $timestamps = false;	

	public function posts() {
		return $this->hasMany('App\Models\Post\Post');
	}
}
