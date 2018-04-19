<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 13 Apr 2018 04:18:01 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class DeliveryDay
 * 
 * @property int $id
 * @property string $shop_id
 * @property int $market_id
 * @property int $day_id
 * @property string $day
 * @property bool $active
 *
 * @package App\Models
 */
class DeliveryDay extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'market_id' => 'int',
		'day_id' => 'int',
		'active' => 'bool'
	];

	protected $fillable = [
		'day',
		'active'
	];
}
