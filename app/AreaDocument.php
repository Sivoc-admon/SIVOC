<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaDocument extends Model
{
    //
    public function folder()
    {
        return $this->hasOne('App\AreaFolder');
    }
}
