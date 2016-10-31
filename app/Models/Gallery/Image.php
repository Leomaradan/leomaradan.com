<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Model;

use App\Models\TouchableTrait;

class Image extends Model
{
    
    use TouchableTrait;
    
    protected $fillable = ['gallery_id','description','image','thumbnail','flickr_id','gallery_order','updated_at','touched'];
   
    public $timestamps = false;
    
    public function gallery() {
        return $this->belongsTo('App\Models\Gallery\Gallery');
    }  
 
    
    public function setDescriptionAttribute($value) {
        if(!isset($this->attributes['description']) || $this->attributes['description'] !== $value) {
            $this->setTouched('description');
        }
        
        $this->attributes['description'] = $value;
    }   
    
    public function setGalleryIdAttribute($value) {
        if(!isset($this->attributes['gallery_id']) || $this->attributes['gallery_id'] !== $value) {
            $this->setTouched('gallery_id');
        }
        
        $this->attributes['gallery_id'] = $value;
    }  
    
    public function setGalleryOrderAttribute($value) {
        if(!isset($this->attributes['gallery_order']) || $this->attributes['gallery_order'] !== $value) {
            $this->setTouched('gallery_order');
        }
        
        $this->attributes['gallery_order'] = $value;
    }   
    
    public function getThumbnailAttribute() {
        if(!isset($this->attributes['thumbnail']) || $this->attributes['gallery_order'] == null) {
            return $this->attributes['image'];
        }
        return $this->attributes['thumbnail'];
    }    
    
    /*
     * gallery_id
gallery_order
description


title
description
cover_image
public
    public function setCategoryAttribute($value) {
        $category = Category::where('name', $value)->first();
        if (!$category) {
            $category = new Category();
            $category->name = $value;
            $category->slug = '';
            $category->save();
        }
        $this->attributes['category_id'] = $category->id;
    }
     */
}
