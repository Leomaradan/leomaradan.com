<?php

namespace App\Models\Post;

use App\Models\SlugTemplate;

use Carbon\Carbon;
use \DB;

class Post extends SlugTemplate
{
	protected $fillable = ['title', 'slug', 'content', 'published_at', 'category_id', 'category', 'lead', 'lead_img'];


	public function category() {
		return $this->belongsTo('App\Models\Post\Category');
	}

	public function tags() {
		return $this->belongsToMany('App\Models\Post\Tag');
	}

	public function scopePublished($query) {
		return $query->where('published_at', '<', DB::raw('NOW()'));
	}

	public function scopeSearchByTitle($query, $q) {
		return $query->where('title', 'LIKE', '%'.$q.'%');
	}

	public function getTagsListAttribute() {
		if($this->tags()) {
			return implode(' ', $this->tags()->pluck('name')->all());	
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

	public function getImageAttribute() {
		if(empty($this->attributes['lead_img'])) {
			return null;
		}
		return $this->attributes['lead_img'];
	}	

	public function setTagsListAttribute($values) {
		$tags = [];

		if($values) {
			foreach ($values as $value) {
				$tag = Tag::where('name', $value)->first();
				if(!$tag) {
					$tag = new Tag();
					$tag->name = $value;
					$tag->slug = '';
					$tag->save();
				}
				$tags[] = $tag->id;
			}	
		}

		return $this->tags()->sync($tags);

	}

	public function setCategoryAttribute($value) {
			$category = Category::where('name', $value)->first();
			if(!$category) {
				$category = new Category();
				$category->name = $value;
				$category->slug = '';
				$category->save();
			}
			$this->attributes['category_id'] = $category->id;
	}


	public function getCategoryNameAttribute() {
		if($this->category) {
			return $this->category->name;	
		}
		return ' ';
	}	

	public function setPublishedAtAttribute($value) {
		if(empty($value)) {
			$this->attributes['published_at'] = null;
		} else {
			$this->attributes['published_at'] =  Carbon::parse($value);
		}
	}	

	public function getDates() {
	    return ['published_at', 'created_at', 'updated_at'];
	}	
}
