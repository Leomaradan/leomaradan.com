<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ["title", "url", "description", "permalink"];
    
    public function scopeFindByPermalink($query, $q) {
        return $query->where('permalink', $q);
    }
    
    public function scopeFindByLink($query, $q) {
        return $query->where('url', $q);
    }
    
    public function scopeFindById($query, $q) {
        return $query->where('id', $q);
    }    
    
    public function setPermalinkAttribute($value) {
        
        
        
        if($value !== null) {
            
            
            $t = rtrim(base64_encode(hash('crc32', $value, true)), '=');

            $this->attributes['permalink'] = strtr($t, '+/', '-_');
        }
    }
    
    public function getDates() {
        return ['created_at'];
    }    
    
    public function getRouteKey() {
        return $this->permalink;
    }    

    
}
