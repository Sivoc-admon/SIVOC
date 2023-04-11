<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequisitionFileItem extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_detail_requisition',
        'name',
        'ruta',
        'comment'
    ];

    public function requisitionDetail()
    {
        return $this->belongsTo('App\DetailRequisition');
    }
}
