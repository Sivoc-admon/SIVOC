<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListaMaterialesFolder extends Model
{
    use Notifiable;
    use SoftDeletes;

    protected $table = 'lista_materiales_folders';

    protected $fillable = [
        'id_project',
        'name',
        'id_padre',
    ];

    public function projects()
    {
        return $this->belongsTo('App\Project');
    }

    public function childs()
    {
        return $this->hasMany('App\ListaMaterialesFolder', 'id_padre', 'id');
    }

    public function files()
    {
        return $this->hasMany('App\ListaMaterialesFile', 'id_lista_materiales_folder');
    }
}
