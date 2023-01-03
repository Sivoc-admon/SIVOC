<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListaCambios extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'id_lista_materiales',
        'id_user',
        'folio',
        'description',
        'modelo',
        'fabricante',
        'cantidad',
        'unidad',
        'tipo',
    ];
}
