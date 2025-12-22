<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpVencimiento extends Model
{
    protected $table = "tmp_vencimientos";

    use HasFactory;

    protected $fillable = [
        'fecha', 
        'moneda', 
        'importe', 
        'concepto',
        'rubro_id',
        'banco_id',
        'tipo',
        'cuenta_id',
        'destino'
        //,
        //'descripcion'
    ];

    public function banco_origen()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

    public function banco_destino()
    {
        return $this->belongsTo(Banco::class, 'destino');
    }

    public function buscoNombreBanco($banco) {
        $texto = 'Efectivo';
        if ($banco != 0) {
            if ($banco != 99) {
                $tmp = Banco::where('id', $banco)->first();
                $texto = $tmp->nombre;
            } else {
                $texto= 'Cheque';
            }
        }
        return $texto;
    }

    public function mostrar() {
        $txt_origen = 'Efectivo';
        /*
        if ($this->banco->id != 0) {
            if ($this->banco->id != 99) {
                $txt_origen = $this->banco->nombre;
            } else {
                $txt_origen = 'Cheque';
            }
        }
        */
        return "Mover: " . $this->buscoNombreBanco($this->banco_id) . " a " . $this->buscoNombreBanco($this->destino) . " " . $this->moneda . ' ' . number_format($this->importe, 2, ',', '.');
    }

}
