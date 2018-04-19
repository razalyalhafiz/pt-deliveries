<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTextOffsetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('text_offset', function(Blueprint $table)
		{
			$table->string('shopid', 55);
			$table->string('offset_min', 11);
			$table->string('content_text');
			$table->string('offset_day', 11);
			$table->boolean('showallproduct');
			$table->integer('id', true);
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
		Schema::drop('text_offset');
	}

}
