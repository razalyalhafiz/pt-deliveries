<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlackoutdaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blackoutdays', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name');
			$table->string('startdate', 55);
			$table->string('enddate', 55);
			$table->integer('marketid');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blackoutdays');
	}

}
