<?php

namespace App\Imports;

use App\ListaMateriales;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;

class MaterialesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable;

    public $id_project;
    public $id_seccion;

    public function __construct($id_project, $id_seccion)
    {
        $this->id_project = $id_project;
        $this->id_seccion = $id_seccion;

    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        return new ListaMateriales([
            'id_project' => $this->id_project,
            'id_seccion' => $this->id_seccion,
            'folio' => $row['folio'],
            'description' => $row['descripcion'],
            'modelo' => $row['modelo'],
            'fabricante' => $row['fabricante'],
            'cantidad' => (integer) $row['cantidad'],
            'unidad' => $row['unidad'],
        ]);
    }


    public function headingRow(): int
    {
        return 9;
    }

    public function rules(): array
    {
        return [
            'cantidad' => Rule::notIn([0, null]),
        ];
    }
    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }
}
