<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    public function attributes()
    {
        return $this->hasMany('App\Models\Product\ProductAttribute');
    }
}
