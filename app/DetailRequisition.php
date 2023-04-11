<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailRequisition extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'num_item',
        'id_clasification',
        'requisition_id',
        'quantity',
        'unit',
        'description',
        'model',
        'preference',
        'urgency',
        'status',
        'comment',
    ];

    public function requisition()
    {
        return $this->belongsTo('App\Requisition');
    }

    public function requisitionFilesItem()
    {
        return $this->hasMany('App\RequisitionFileItem', 'id_detail_requisition');
    }
}
