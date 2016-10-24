<?php

namespace App\Models\Rss;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Article extends Model
{
    protected $table = "rss_items";
    
    protected $fillable = ['flux_id', 'guid', 'read', 'title', 'link', 'published_at', 'description'];    
    
    public $timestamps = false;    

    public function flux() {
        return $this->belongsTo('App\Models\Rss\Flux');
    }      
    
    public function scopeFindByGuid($query, $q) {
        return $query->where('guid', $q);
    }    
    
    public function getPublishedAtAttribute() {
        return new Date($this->attributes['published_at']);
    }    
    
    public function getRouteKey() {
        return $this->id;
    }    
}
