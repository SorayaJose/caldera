<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vencimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha', 
        'moneda', 
        'importe', 
        //'concepto',
        'rubro_id',
        'banco_id',
        'tipo'
        //,
        //'descripcion'
    ];

    public function rubro() {
        return $this->belongsTo(Rubro::class);
    }

    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }

    public function tmpPago() {
        return $this->hasOne(TmpPago::class);
    }


    public function mostrarFecha() {
        return Carbon::parse($this->fecha)->format('d-m-Y');
    }

    public function mostrarFechaCorta() {
        return Carbon::parse($this->fecha)->format('d-m');
    }

    public function mostrarTipoTexto() {
        if ($this->tipo == 'P') {
            return "Personal";
        } elseif ($this->tipo == 'S') {
            return "Sivezul";
        } 
        return "-";
    }

    public function mostrar() {
        return $this->moneda . ' ' . number_format($this->importe, 2, ',', '.');;
    }
}
