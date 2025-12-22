<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'moneda', 'tipo', 'color', 'banco_id'
    ];

    public function mostrarColor() {
        if ($this->color == 1) {
            return "Efectivo";
        } elseif ($this->color == 2) {
            return "Transferencia";
        } 
        return "Se debe pagar";
    }

    public function color() {
        if ($this->color == 1) {
            return "gray";
        } elseif ($this->color == 2) {
            return "red";
        } else { 
            return "blue";
        }
        return "gray";
    }

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    public function muestroNombreBanco() {
        if ($this->banco_id == null) {
            return "-";
        }
        return $this->banco->nombre;
    }

}
