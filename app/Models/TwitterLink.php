<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\TouchableTrait;

class TwitterLink extends Model
{
    
    use TouchableTrait;
    
    protected $fillable = ['created_at', 'id_twitter', 'text', 'user_name', 'user_id', 'public', 'touched'];
    public $timestamps = false;
    
    public function setTextAttribute($value) {
        if(!isset($this->attributes['text']) || $this->attributes['text'] !== $value) {
            $this->setTouched('text');
        }
        
        $this->attributes['text'] = $value;
    }      
    
    public function setPublicAttribute($value) {
        if(!isset($this->attributes['public']) || $this->attributes['public'] !== $value) {
            $this->setTouched('public');
        }
        
        $this->attributes['public'] = $value;
    }     
    /*
     * 
     * 
     * created_at
id_str
text
urls[]
 expanded_url
 display_url
media[]
 media_url_https
 sizes[]
  medium
    w
    h
    resize (fit/crop)
  thumb
    ...
  large
    ...
  small
    ---

user
 screen_name
 name
     */
}
