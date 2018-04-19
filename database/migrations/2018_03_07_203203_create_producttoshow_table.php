<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProducttoshowTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('producttoshow', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('product_id');
			$table->boolean('showhide');
			$table->string('shopid', 55);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('producttoshow');
	}

}
