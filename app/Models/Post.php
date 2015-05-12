<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Post extends Model {

	protected $fillable = ['title', 'slug', 'content', 'published_at', 'tags_list', 'category_id', 'category', 'lead'];


	public function category() {
		return $this->belongsTo('App\Models\PostsCategory');
	}

	public function tags() {
		return $this->belongsToMany('App\Models\Tag');
	}


	public function scopePublished($query) {
		return $query->where('published_at', '<', DB::raw('NOW()'));
	}

	public function scopeSearchByTitle($query, $q) {
		return $query->where('title', 'LIKE', '%'.$q.'%');
	}

	public function scopeFindBySlug($query, $q) {
		return $query->where('slug', $q)->firstOrFail();
	}

	public function scopeFindById($query, $q) {
		return $query->where('id', $q)->firstOrFail();
	}	

	public function setSlugAttribute($value) {
		if(empty($value)) {
			$this->attributes['slug'] = Str::slug($this->title);
		} else {
			$this->attributes['slug'] = Str::slug($value);
		}
	}

	public function getTagsListAttribute() {
		if($this->tags()) {
			return implode(' ', $this->tags()->lists('name'));	
		}
		return ' ';
		
	}

	public function getLeadAttribute() {
		if(empty($this->attributes['lead'])) {
			$pos = strpos($this->content, chr(13).chr(10));
			if($pos === false) {
				$pos = strpos($this->content, ' ', min(strlen($this->content), 200));
				if($pos === false) {
					$pos = min(strlen($this->content), 200);
				}
			} 

			return substr($this->content, 0, $pos);
		}

		return $this->attributes['lead'];
	}

	public function setTagsListAttribute($values) {
		$tags = [];

		if($values) {
			foreach ($values as $value) {
				$tags[] = Tag::firstOrCreate(['name' => $value])->id;
			}	
		}


		return $this->tags()->sync($tags);

	}

	public function setCategoryAttribute($value) {
			$category = PostsCategory::firstOrCreate(['name' => $value]);	
			$this->attributes['category_id'] = $category->id;
	}


	public function getCategoryNameAttribute() {
		if($this->category) {
			return $this->category->name;	
		}
		return ' ';
	}	

	public function setPublishedAtAttribute($value) {
		if($value == "") {
			$this->attributes['published_at'] = null;
		}
	}	

	public function getDates() {
	    return ['published_at', 'created_at', 'updated_at'];
	}	


	public function getRouteKey() {
		return $this->slug;
	}
}
