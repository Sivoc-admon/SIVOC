<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requisition extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'no_requisition',
        'id_area',
        'id_user',
        'nom_proyecto',
        'status',
        'tipo',
        'aprobacion',
        'comment',
    ];

    public function requisitionDetail()
    {
        return $this->hasMany('App\DetailRequisition');
    }

    public function requisitionFiles()
    {
        return $this->hasMany('App\RequisitionFile');
    }

    public function requisitionHistory()
    {
        return $this->hasMany('App\RequisitionHistory');
    }
}
