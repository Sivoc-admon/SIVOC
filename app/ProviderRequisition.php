<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProviderRequisition extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_detail_requisition',
        'num_item',
        'name',
        'unit_price',
    ];
}
