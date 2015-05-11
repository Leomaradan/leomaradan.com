<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRssSourcesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('rss_categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("name");
			$table->timestamps();
		});

		Schema::create('rss_sources', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("title");
			$table->string("url");
			$table->integer('category_id')->unsigned()->nullable();
			$table->foreign('category_id')->references('id')
				  ->on('rss_categories')
				  ->onUpdate('cascade')
				  ->onDelete('set null');
			$table->string('timer_update');	  
		    $table->timestamp('last_update');
			$table->timestamps();
		});


		Schema::create('rss_articles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('source_id')->unsigned();
			$table->foreign('source_id')->references('id')
				  ->on('rss_sources')
				  ->onUpdate('cascade')			
				  ->onDelete('cascade');			
			$table->string("url");
			$table->string("title");
			$table->dateTime('date_article');
			$table->longText('content');
			$table->boolean('is_read')->default(false);
			$table->boolean('is_kept')->default(false);

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
		Schema::drop('rss_articles');
		Schema::drop('rss_sources');
		Schema::drop('rss_categories');

	}

}
