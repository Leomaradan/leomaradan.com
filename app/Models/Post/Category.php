<?php

namespace App\Models\Post;

use App\Models\SlugTemplate;

class Category extends SlugTemplate {

    protected $fillable = ['name', 'slug'];
    public $timestamps = false;

    public function posts() {
        return $this->hasMany('App\Models\Post\Post');
    }

    public function getNbUsesAttribute() {
        return count($this->posts()->published()->get());
    }

    public function scopePublished($query) {

        return $query->whereHas('posts', function ($query) {
                    $query->published();
                });
    }

}
