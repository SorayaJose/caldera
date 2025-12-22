<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dolar extends Model
{
    use HasFactory;

    protected $table = 'dolares';

    protected $fillable = [
        'fecha',
        'brou',
        'compra',
        'venta'
    ];

    public function mostrarFecha() {
        return Carbon::parse($this->fecha)->format('d-m-Y');
    }

    public function mostrarBrou() {
        return '$ ' . number_format($this->brou, 2, ',', '.');;
    }
    public function mostrarCompra() {
        return '$ ' . number_format($this->compra, 2, ',', '.');;
    }
    public function mostrarVenta() {
        return '$ ' . number_format($this->venta, 2, ',', '.');;
    }
}
