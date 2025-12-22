<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpMovimiento extends Model
{
    protected $table = "tmp_movimientos";

    use HasFactory;

    protected $fillable = [
        'mov_id',
        'mov_tipo',
        'moneda',
        'importe',
        'tipo',
        'cuenta_id',
        'fecha',
        'destino',
        'comentario'
    ];

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class, 'cuenta_id');
    }


    public function cuentaDestino()
    {
        return $this->belongsTo(Cuenta::class, 'destino');
    }
    
    public function mostrar() {
        return $this->moneda . ' ' . number_format($this->importe, 2, ',', '.');;
    }
}
