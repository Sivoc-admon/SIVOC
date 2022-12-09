<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListaMaterialesFile extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'lista_materiales_files';

    protected $fillable = [
        'id_lista_materiales_folder',
        'name',
        'ruta',
    ];

    public function folder()
    {
        return $this->belongsTo('App\ProjectFolder');
    }
}
