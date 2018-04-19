<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 13 Apr 2018 04:18:01 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DeliveryHour
 * 
 * @property int $id
 * @property int $shop_id
 * @property int $market_id
 * @property int $day_id
 * @property string $day
 * @property string $time_from
 * @property string $time_to
 * @property int $slot_limit
 *
 * @package App\Models
 */
class DeliveryHour extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'shop_id' => 'int',
		'market_id' => 'int',
		'day_id' => 'int',
		'slot_limit' => 'int'
	];

	protected $fillable = [
		'day_id',
		'time_from',
		'time_to',
		'slot_limit'
	];
}
