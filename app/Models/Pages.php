<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model {

	protected $fillable = ["title", "slug", "content"];

	public function scopeFindBySlug($query, $q) {
		return $query->where('slug', $q)->firstOrFail();
	}

	public function scopeFindById($query, $q) {
		return $query->where('id', $q)->firstOrFail();
	}	

}
