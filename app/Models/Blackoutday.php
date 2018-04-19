<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 13 Apr 2018 04:18:01 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BlackoutDay
 * 
 * @property int $id
 * @property int $shop_id
 * @property int $market_id
 * @property string $name
 * @property string $date
 * @property string $start_date
 * @property string $end_date
 *
 * @package App\Models
 */
class BlackoutDay extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'shop_id' => 'int',
		'market_id' => 'int'
	];

	protected $fillable = [
		'name',
		'date',
		'start_date',
		'end_date'
	];
}
