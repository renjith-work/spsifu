<?php

namespace App\Models\Measurement;

use Illuminate\Database\Eloquent\Model;

class MeasurementProfile extends Model
{
    public function measurementAttributeValue()
    {
        return $this->belongsToMany('App\Models\Measurement\MeasurementAttributeValue', 'measurement_profile_values', 'profile_id', 'value_id');
    }

    public function attributeSet()
    {
        return $this->belongsTo('App\Models\Product\ProductAttributeSet', 'product_attribute_set_id');
    }
}
