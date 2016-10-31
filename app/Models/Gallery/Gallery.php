<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Model;

use App\Models\TouchableTrait;

class Gallery extends Model {
    
    use TouchableTrait;    

    protected $fillable = ['title', 'description', 'cover_image', 'flickr_id', 'public', 'updated_at', 'touched'];
    
    public $timestamps = false;

    public function images() {
        return $this->hasMany('App\Models\Gallery\Image');
    }

    public function cover() {
        return $this->hasOne('App\Models\Gallery\Image', 'id', 'cover_image');
    }
    
    public function getCoverSrcAttribute() {
        return $this->cover()->first()->image;
    }
    
    public function getCoverThumbnailAttribute() {
        return $this->cover()->first()->thumbnail;
    }    

    public function scopeFindByFlickrId($query, $q) {
        return $query->where('flickr_id', $q);
    }
    
    public function scopeFindById($query, $q) {
        return $query->where('id', $q);
    }    

    public function scopePublished($query) {
        return $query->where('public', 1)->orderBy('updated_at', 'desc');
    }    
    
    public function setTitleAttribute($value) {
        if(!isset($this->attributes['title']) || $this->attributes['title'] !== $value) {
            $this->setTouched('title');
        }
        
        $this->attributes['title'] = $value;
    }
    
    public function setDescriptionAttribute($value) {
        if(!isset($this->attributes['description']) || $this->attributes['description'] !== $value) {
            $this->setTouched('description');
        }
        
        $this->attributes['description'] = $value;
    }   
    
    public function setCoverImageAttribute($value) {
        if(!isset($this->attributes['cover_image']) || $this->attributes['cover_image'] !== $value) {
            $this->setTouched('cover_image');
        }
        
        $this->attributes['cover_image'] = $value;
    }  
    
    public function setPublicAttribute($value) {
        if(!isset($this->attributes['public']) || $this->attributes['public'] !== $value) {
            $this->setTouched('public');
        }
        
        $this->attributes['public'] = $value;
    }       
    
}
