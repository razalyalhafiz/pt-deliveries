<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 13 Apr 2018 04:18:01 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Delivery
 * 
 * @property int $id
 * @property int $shop_id
 * @property int $market_id
 * @property int $timeslot_id
 * @property string $order_id
 * @property string $delivery_date
 * @property string $delivery_time
 * @property string $customer
 * @property string $phone
 * @property string $address
 * @property string $assignee
 * @property string $tookan_id
 * @property string $status
 * @property string $completed_time
 * @property \Carbon\Carbon $created_on
 *
 * @package App\Models
 */
class Delivery extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'shop_id' => 'int',
		'market_id' => 'int',
		'timeslot_id' => 'int'
	];

	protected $dates = [
		'created_on'
	];

	protected $fillable = [
		'shop_id',
		'market_id',
		'timeslot_id',
		'order_id',
		'delivery_date',
		'delivery_time',
		'customer',
		'phone',
		'address',
		'assignee',
		'tookan_id',
		'status',
		'completed_time',
		'created_on'
	];
}
