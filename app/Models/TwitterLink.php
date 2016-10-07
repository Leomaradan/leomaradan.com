<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwitterLink extends Model
{
    protected $fillable = ["created_at", "id_twitter", "text", "user_name", "user_id"];
    public $timestamps = false;
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
