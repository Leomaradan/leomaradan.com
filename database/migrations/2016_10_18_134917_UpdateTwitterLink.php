<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTwitterLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('twitter_links', function(Blueprint $table) 
         {
            $table->string('reply_to_id')->nullable();
            $table->string('touched')->default('');
            $table->boolean('public')->default(true);
         });
         
         Schema::table('twitter_links_media', function(Blueprint $table) {
            $table->string('id_twitter')->unique();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('twitter_links', function(Blueprint $table)
        {
            $table->dropColumn('reply_to_id');
            $table->dropColumn('touched');
            $table->dropColumn('public');
        });
        
        Schema::table('twitter_links_media', function(Blueprint $table)
        {
            $table->dropColumn('id_twitter');
        });      
    }
}
