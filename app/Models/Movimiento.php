<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'mov_id',
        'mov_tipo',
        'moneda',
        'importe',
        'tipo',
        'cuenta_id',
        'fecha',
        'destino'
    ];
}
