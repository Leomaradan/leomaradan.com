<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRssTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rss_flux', function(Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('url')->unique();
            $table->string('category');   
            $table->integer('expire_days')->default(60);
            $table->boolean('purge_unread')->default(false);
            $table->timestamp('updated_at')->nullable();
        });
        
        Schema::create('rss_items', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('flux_id');
            $table->foreign('flux_id')->references('id')->on('rss_flux')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('guid');
            $table->boolean('read')->default(false);
            $table->boolean('favorite')->default(false);
            $table->string('title');
            $table->string('link');
            $table->timestamp('published_at');
            $table->binary('description');         
            
            $table->unique(['flux_id','guid']);
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rss_items');
        
        Schema::drop('rss_flux');
    }
}
