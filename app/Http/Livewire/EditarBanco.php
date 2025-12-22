<?php

namespace App\Http\Livewire;

use App\Models\Banco;
use Livewire\Component;

class EditarBanco extends Component
{
    public $banco_id;
    public $nombre;
    public $moneda;
    public $tipo;
    public $numero;

    protected $rules = [
        'nombre' => 'required|string',
        'tipo' => 'required',
        'moneda' => 'required',
        'numero' => 'nullable'
    ];

    public function mount(Banco $banco) {
        $this->banco_id = $banco->id;
        $this->nombre = $banco->nombre;
        $this->moneda = $banco->moneda;
        $this->tipo = cache('modoSivezul');
        $this->numero = $banco->numero; 
    }

    
    public function editarBanco() {
        $datos = $this->validate();
//        dd($datos['items']);

        // encontrar la vacante
        $banco = Banco::find($this->banco_id);

        // asignar nuevos valores
        $banco->nombre  = $datos['nombre'];
        $banco->tipo = $datos['tipo'];
        $banco->moneda = $datos['moneda'];
        $banco->numero = $datos['numero'];  

        // guardar la vacante
        $banco->save();

        // armar el mensaje
        session()->flash('mensaje', 'El banco se modificó correctamente');

        // redireccionar al usuario
        return redirect()->route('bancos.index');
    }
    
    public function render() {
        return view('livewire.editar-banco');
    }
}