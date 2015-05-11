<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAdvancedOptions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('posts_categories', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("name");
			$table->string("slug");
			$table->timestamps();
		});

		Schema::table('posts', function(Blueprint $table)
		{
			$table->dateTime('published_at')->nullable();
			$table->integer('category_id')->unsigned()->nullable();
			$table->foreign('category_id')->references('id')
				  ->on('posts_categories')
				  ->onUpdate('cascade')
				  ->onDelete('set null');
			$table->text('tags')->default('');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('posts', function(Blueprint $table)
		{
			
			$table->dropForeign('posts_category_id_foreign');
			$table->dropColumn('category_id');
			$table->dropColumn('published_at');
			$table->dropColumn('tags');
		});

		Schema::drop('posts_categories');
	}

}
