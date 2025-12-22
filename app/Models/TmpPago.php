<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TmpPago extends Model
{
    use HasFactory;

    protected $fillable = [
        'cuenta_id',
        'vencimiento_id'
    ];

    public function vencimiento() {
        return $this->belongsTo(Vencimiento::class);
    }

    public function cuenta() {
        return $this->belongsTo(Cuenta::class);
    }
}
