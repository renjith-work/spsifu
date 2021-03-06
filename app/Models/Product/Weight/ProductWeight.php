<?php

namespace App\Models\Product\Weight;

use Illuminate\Database\Eloquent\Model;

class ProductWeight extends Model
{
    public function product()
    {
        return $this->belongsTo('App\Models\Product\Product');
    }
}
