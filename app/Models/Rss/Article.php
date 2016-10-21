<?php

namespace App\Models\Rss;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = "rss_items";
    
    protected $fillable = ['flux_id', 'guid', 'read', 'title', 'link', 'published_at', 'description'];    

    public function flux() {
        return $this->belongsTo('App\Models\Rss\Flux');
    }      
    
    public function scopeFindByGuid($query, $q) {
        return $query->where('guid', $q);
    }    
}
