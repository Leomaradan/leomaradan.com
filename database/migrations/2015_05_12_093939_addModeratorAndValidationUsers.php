<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModeratorAndValidationUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->enum('status', ['inactive', 'user', 'moderator', 'admin'])->default('inactive');
		});		

		$users = DB::table('users')->where('admin', true)->update(['status' => 'admin']);


		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('admin');
		});				
			
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn('status');
			$table->boolean('admin')->default(false);
		});	
	}

}
