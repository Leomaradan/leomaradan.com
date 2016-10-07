<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model {

    protected $fillable = ['name', 'description', 'cover_image', 'flickr_id'];

    public function images() {

        return $this->has_many('images');
    }

    public function cover() {
        return $this->hasOne('App\Models\Gallery\Image', 'id', 'cover_image');
    }
    
    public function getCoverSrcAttribute() {
        return $this->cover()->first()->image;
    }

    public function scopeFindByFlickrId($query, $q) {
        return $query->where('flickr_id', $q);
    }

    public function scopePublished($query) {
        return $query->where('public', 1)->orderBy('updated_at');
    }    
    
}
