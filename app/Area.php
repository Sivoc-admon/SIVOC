<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model{

    public function areaFolder(){
        return $this->hasMany('App\AreaFolder', 'id', 'area_id');
    }
}