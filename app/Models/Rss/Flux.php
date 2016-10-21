<?php

namespace App\Models\Rss;

use Illuminate\Database\Eloquent\Model;

class Flux extends Model
{
    protected $table = "rss_flux";
    
    protected $fillable = ['title', 'url', 'category', 'updated_at'];
    
    public $timestamps = false;    
    
    public function articles() {
        return $this->hasMany('App\Models\Rss\Article');
        //        return $this->hasMany('App\Models\Post\Post');
    }    
    
 /*
  *             $table->increments('id');
            $table->string('title');
            $table->string('url');
            $table->string('category');   
            $table->timestamp('updated_at');
  */
}
