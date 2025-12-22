<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cuenta extends Model
{
    use HasFactory;

    private $color = "blue";

    protected $fillable = [
        'banco_id',
        'tipo',
        'moneda',
        'saldo',
        'saldo_tmp',
        'numero'
    ];

    protected $casts = [
        'saldo' => 'double',
        'saldo_tmp' => 'double',
    ];

    public function banco()
    {
        return $this->belongsTo(Banco::class);
    }

    public function vencimientos() {     
        return $this->hasMany(Vencimiento::class)->orderBy('created_at', 'DESC');
    }
    

    public function saldo() {
        return $this->saldo;
    }


    public function color()
    {
        return (($this->saldo - $this->saldo_tmp) < 0) ? 'red' : 'green';
    }

    public function mostrarTipoTexto() {
        if ($this->tipo == 'P') {
            return "Personal";
        } elseif ($this->tipo == 'S') {
            return "Sivezul";
        } 
        return "-";
    }
}
