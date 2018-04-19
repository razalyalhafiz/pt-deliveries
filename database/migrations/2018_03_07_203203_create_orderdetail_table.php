<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderdetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orderdetail', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('orderid');
			$table->string('orderdate', 55);
			$table->string('ordertime');
			$table->string('market');
			$table->integer('ordername');
			$table->boolean('status');
			$table->string('customer');
			$table->string('address');
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
		Schema::drop('orderdetail');
	}

}
