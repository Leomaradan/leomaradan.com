<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('images', function(Blueprint $table) 
         {
            $table->dropColumn('created_at');
            $table->string('touched')->default('');
         });        
         

         Schema::table('galleries', function(Blueprint $table) 
         {
            $table->dropColumn('created_at');
            $table->string('touched')->default('');
         });        
           
         
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('images', function(Blueprint $table) 
         {
            $table->timestamp('created_at');
            $table->dropColumn('touched');
         });  
         
         Schema::table('galleries', function(Blueprint $table) 
         {
            $table->timestamp('created_at');
            $table->dropColumn('touched');
         });         
        
    }
}
