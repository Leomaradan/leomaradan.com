<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function(Blueprint $table)
        {
          $table->increments('id');
          $table->string('title');
          $table->text('description');
          $table->integer('cover_image')->nullable();
          $table->foreign('cover_image')->references('id')->on('galleries')->onDelete('SET NULL')->onUpdate('CASCADE');
          $table->boolean('public')->default(false);
          $table->string('flickr_id')->nullable()->unique();
          $table->timestamps();
        });
      
        Schema::create('images', function(Blueprint $table)
        {
          $table->increments('id');
          $table->integer('gallery_id')->nullable();
          $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('SET NULL')->onUpdate('CASCADE');
          $table->string('flickr_id')->nullable()->unique();
          $table->integer('gallery_order')->default(0);
          $table->string('image');
          $table->string('description');
          $table->timestamps();
        });      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('images');
        Schema::drop('galleries');
    }
}
