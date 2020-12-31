<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model{

    public function areaFolder(){
        return $this->hasMany(FolderArea::class, 'id', 'area_id');
    }
}