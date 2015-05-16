<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShaarlisTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shaarlis', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('slug');			
			$table->string('url');		
			$table->text('content');	
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
		Schema::drop('shaarlis');
	}

}
