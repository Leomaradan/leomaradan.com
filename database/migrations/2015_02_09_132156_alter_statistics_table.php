<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStatisticsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		\DB::statement("ALTER TABLE `statistics` CHANGE COLUMN `errorMessage` `errorMessage` text NULL;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		\DB::statement("ALTER TABLE `statistics` CHANGE COLUMN `errorMessage` `errorMessage` VARCHAR(64) NOT NULL;");
	}

}
