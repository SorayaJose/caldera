<?php

namespace App\Http\Livewire;

use App\Models\Banco;
use App\Models\Cuenta;
use Livewire\Component;

class EditarCuenta extends Component
{
    public $cuenta_id;
    public $banco;
    public $moneda;
    public $tipo;
    public $numero;
    public $saldo;

    protected $rules = [
        'banco' => 'numeric|required',
        'tipo' => 'required',
        'moneda' => 'required',
        'numero' => 'nullable',
        'saldo' => 'numeric|nullable'
    ];

    public function mount(Cuenta $cuenta) {
        $this->cuenta_id = $cuenta->id;
        $this->banco = $cuenta->banco_id;
        $this->moneda = $cuenta->moneda;
        $this->tipo = cache('modoSivezul');
        $this->numero = $cuenta->numero; 
        $this->saldo = $cuenta->saldo; 
    }
    
    public function editarCuenta() {
        $datos = $this->validate();
//        dd($datos['items']);

        // encontrar la vacante
        $cuenta = Cuenta::find($this->cuenta_id);

        // asignar nuevos valores
        $cuenta->tipo = $datos['tipo'];
        $cuenta->moneda = $datos['moneda'];
        $cuenta->numero = $datos['numero'];
        $cuenta->banco_id = $datos['banco'];
        $cuenta->saldo = $datos['saldo'];   

        // guardar la vacante
        $cuenta->save();

        // armar el mensaje
        session()->flash('mensaje', 'La cuenta se modificó correctamente');

        // redireccionar al usuario
        return redirect()->route('cuentas.index');
    }
    
    public function render() {
        $bancos = Banco::all();
        return view('livewire.editar-cuenta', [
            'bancos' => $bancos ]);
    }
}