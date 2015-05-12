<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;

class Tag extends Model {

	
	public $fillable = ['name', 'slug'];

	public $timestamps = false;

	public function posts() {
		return $this->belongsToMany('App\Models\Post');
	}

	public function getRouteKey() {
		return $this->slug;
	}

	public function scopeFindBySlug($query, $q) {
		return $query->where('slug', $q)->firstOrFail();
	}

	public function scopeFindById($query, $q) {
		return $query->where('id', $q)->firstOrFail();
	}	

	public function setSlugAttribute($value) {
		if(empty($value)) {
			$this->attributes['slug'] = Str::slug($this->name);
		} else {
			$this->attributes['slug'] = Str::slug($value);
		}
	}		


}
