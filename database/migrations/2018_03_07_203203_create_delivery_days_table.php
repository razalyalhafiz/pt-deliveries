<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeliveryDaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('delivery_days', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('shopid', 11);
			$table->string('day', 11);
			$table->boolean('onoff');
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
		Schema::drop('delivery_days');
	}

}
