<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeliveryHoursTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('delivery_hours', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('shopid');
			$table->integer('dayid');
			$table->string('deliveryfrom', 55);
			$table->string('deliveryto', 55);
			$table->integer('limited');
			$table->integer('deliveryslot');
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
		Schema::drop('delivery_hours');
	}

}
