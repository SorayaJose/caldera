<?php

namespace App\Http\Livewire;

use App\Models\Banco;
use App\Models\Cuenta;
use Livewire\Component;

class CrearCuenta extends Component
{
    public $banco;
    public $tipo;
    public $moneda;
    public $numero;
    public $saldo;

    public $open = false;

    protected $rules = [
        'banco' => 'numeric|required',
        'tipo' => 'required',
        'moneda' => 'required',
        'numero' => 'nullable',
        'saldo' => 'numeric|nullable'
    ];

    public function mount() {
        $this->tipo = cache('modoSivezul');
    }

    public function crearCuenta() {
        $datos = $this->validate();
        //dd($datos);
        // crear el cuenta
        
        $cuenta = Cuenta::create([
            'banco_id' => $datos['banco'],
            'moneda' => $datos['moneda'],
            'tipo' => $datos['tipo'],     
            'numero' => $datos['numero'],
            'saldo' => $datos['saldo'],
            'saldo_tmp' => 0
        ]);
        
        
        // crear un mensaje
        session()->flash('mensaje', 'La cuenta se publicó correctamente');

        //redireccionar al usuario
        return redirect()->route('cuentas.index');
    }

    public function save()
    {
        //dump($this->companies);
    }
    
    public function render()
    {
        $bancos = Banco::all();
        return view('livewire.crear-cuenta', [
            'bancos' => $bancos
        ]);
    }
}
