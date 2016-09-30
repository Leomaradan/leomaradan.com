<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('zone');
            
            $table->integer('parent')->unsigned()->nullable();
            $table->foreign('parent')->references('id')
                  ->on('menus')
                  ->onUpdate('cascade')
                  ->onDelete('set null'); 
            
            $table->enum('type', ['internalLink', 'externalLink', 'separator'])->nullable();
            $table->string('title');
            $table->string('link');
            $table->tinyInteger('order');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('menus');
    }
}
