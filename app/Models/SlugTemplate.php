<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class SlugTemplate extends Model
{

	private $orderForSlugGenerator = ['title', 'name', 'id'];

	public function setSlugAttribute($value) {
		if(empty($value)) {
			foreach ($this->orderForSlugGenerator as $key) {
				if($this->$key !== null) {
					$str = ($key != 'id') ? $this->$key : 'i' . $this->id;
					$this->attributes['slug'] = Str::slug($str);
					break;
				}
			}
			
		} else {
			$this->attributes['slug'] = Str::slug($value);
		}
	}

	public function getRouteKey() {
		return $this->slug;
	}	

	public function scopeFindBySlug($query, $q) {
		return $query->where('slug', $q)->first();
	}

	public function scopeFindById($query, $q) {
		return $query->where('id', $q)->first();
	}	
}
