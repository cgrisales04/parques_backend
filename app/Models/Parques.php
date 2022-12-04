<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parques extends Model
{
    use HasFactory;
    protected $table = "parques";
    protected $id = "Codigo_Parques";
    public $timestaps = false;

    protected $fillable = [
        'Nombre_Parques',
        'Direccion_Parques',
        'Telefono_Parques',
        'Codigo_Municipios'
    ];
}