<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 13 Apr 2018 04:18:01 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Postcode
 * 
 * @property int $id
 * @property int $shop_id
 * @property int $market_id
 * @property int $postcode
 * @property string $area
 *
 * @package App\Models
 */
class Postcode extends Eloquent
{
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'shop_id' => 'int',
		'market_id' => 'int',
		'postcode' => 'int'
	];

	protected $fillable = [
		'market_id',
		'postcode',
		'area'
	];
}
