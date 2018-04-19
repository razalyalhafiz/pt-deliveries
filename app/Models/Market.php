<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 13 Apr 2018 04:18:01 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Market
 * 
 * @property int $id
 * @property string $shop_id
 * @property string $market_name
 * @property int $status
 * @property int $lead_offset
 *
 * @package App\Models
 */
class Market extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'status' => 'int',
		'lead_offset' => 'int'
	];

	protected $fillable = [
		'shop_id',
		'market_name',
		'status',
		'lead_offset'
	];
}
