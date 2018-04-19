<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShopTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('shop', function(Blueprint $table)
		{
			$table->integer('shop_pid', true);
			$table->string('code');
			$table->string('shop_name');
			$table->string('name');
			$table->string('shop_email');
			$table->string('currency', 10);
			$table->string('owner_name');
			$table->string('phone_no', 30);
			$table->text('street', 65535);
			$table->string('city', 100);
			$table->string('zip', 10);
			$table->string('country', 100);
			$table->string('hmac');
			$table->string('signature');
			$table->string('access_token');
			$table->string('payment_status');
			$table->string('payment_id');
			$table->dateTime('date_created');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('shop');
	}

}
