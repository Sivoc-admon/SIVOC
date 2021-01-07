<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndicatorType extends Model
{
    public function indicator(){
        return $this->belongsTo(Indicator::class);
    }
}
