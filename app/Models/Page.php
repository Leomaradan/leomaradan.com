<?php 
namespace App\Models;

class Page extends SlugTemplate {

	protected $fillable = ["title", "slug", "content"];

    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];	

}