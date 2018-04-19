<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 13 Apr 2018 04:18:01 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Shop
 * 
 * @property int $id
 * @property string $shopify_domain
 * @property string $shopify_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $charge_id
 * @property bool $grandfathered
 *
 * @package App\Models
 */
class Shop extends Eloquent
{
	protected $casts = [
		'charge_id' => 'int',
		'grandfathered' => 'bool'
	];

	protected $hidden = [
		'shopify_token'
	];

	protected $fillable = [
		'shopify_domain',
		'shopify_token',
		'charge_id',
		'grandfathered'
	];
}
