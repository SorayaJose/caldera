<?php

namespace App\Http\Livewire;

use App\Models\Banco;
use Livewire\Component;

class CrearBanco extends Component
{
    public $nombre;
    public $tipo;
    public $moneda;
    public $numero;

    public $open = false;

    protected $rules = [
        'nombre' => 'required|string',
        'tipo' => 'required',
        'moneda' => 'required',
        'numero' => 'nullable'
    ];

    public function crearBanco() {
        $datos = $this->validate();

        // crear el banco
        //dd($datos);
        
        $banco = Banco::create([
            'nombre' => $datos['nombre'],
            'moneda' => $datos['moneda'],
            'tipo' => $datos['tipo'],     
            'numero' => $datos['numero']
        ]);
        
        
        // crear un mensaje
        session()->flash('mensaje', 'El banco se publicó correctamente');

        //redireccionar al usuario
        return redirect()->route('bancos.index');
    }

    public function save()
    {
        //dump($this->companies);
    }
    
    public function render()
    {
        return view('livewire.crear-banco');
    }
}
