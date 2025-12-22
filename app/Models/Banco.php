<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banco extends Model
{
    use HasFactory;
    private $saldo;
    private $color = "blue";

    protected $fillable = [
        'nombre',
        'tipo',
        'moneda',
        'numero'
    ];

    public function cuentas() {
        return $this->hasMany(Cuenta::class)->orderBy('moneda', 'DESC');
    }

    public function color() {
        /*
        // Si alguna cuenta tiene saldo negativo → ROJO
        foreach ($this->cuentas as $cuenta) {
            if ($cuenta->saldo - $cuenta->saldo_tmp < 0) {
                return 'red';
            }
        }

        // Si todas las cuentas están en positivo → VERDE
        return 'green';
        */
        $en_cero = 0;
        foreach ($this->cuentas as $cuenta) {
            //echo "id: " . $cuenta->id . "<br>";
            //echo "sdo: " . $cuenta->saldo. "<br>";
            //echo "tmp: " . $cuenta->saldo_tmp . "<br>";
            if (($cuenta->saldo - $cuenta->saldo_tmp) < 0) {
                return 'red';
            } else if (($cuenta->saldo - $cuenta->saldo_tmp) > 0) {
                $en_cero++;
            }
        }
        if ($en_cero == 0) {
            return 'gray';
        }

        return 'green';
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
