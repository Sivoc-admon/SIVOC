<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AreaFolder extends Model
{
    //
    public function areaDocuments()
    {
        return $this->hasMany('App\AreaDocument');
    }
}
