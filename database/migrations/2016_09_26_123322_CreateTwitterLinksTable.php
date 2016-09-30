<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwitterLinksTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('twitter_link', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamp('created_at');
            $table->string('id_twitter')->unique();
            $table->string('text');
            
            $table->string('user_name');
            $table->string('user_id');
        });
        
        Schema::create('twitter_link_media', function(Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['url', 'image'])->default('url');
            
            $table->string('display_url');
            $table->string('url');
            
            $table->json('config');

            $table->integer('link_id')->unsigned()->nullable();
            $table->foreign('link_id')->references('id')
                  ->on('twitter_link')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');            

        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('twitter_link_media');
        Schema::drop('twitter_link');
    }

}
