<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
	public function products()
	{
		return $this->hasMany('App\Models\Product\Product');
	}

	public function status()
	{
		return $this->belongsTo('App\Models\Status', 'status_id');
	}
}
