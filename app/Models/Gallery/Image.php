<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = array('gallery_id','description','image','flickr_id');
    
    public function gallery() {
        return $this->belongsTo('App\Models\Gallery\Gallery');
    }    
}
