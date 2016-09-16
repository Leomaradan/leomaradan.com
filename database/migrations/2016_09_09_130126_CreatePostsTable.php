<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('categories', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string("name");
            $table->string("slug");
            $table->timestamps();
            $table->softDeletes();
        });   

        Schema::create('posts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->timestamps();
            $table->softDeletes();

            $table->dateTime('published_at')->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')
                  ->on('categories')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
            $table->text('tags');     

            $table->text('lead')->nullable();
            $table->string('lead_img')->nullable();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories');
        Schema::drop('posts');
    }
}
