<?php

namespace App\Http\Livewire;

use App\Models\Dolar;
use Livewire\Component;
use Illuminate\Support\Carbon;

class CrearDolar extends Component
{
    public $fecha;
    public $brou;
    public $compra;
    public $venta;

    protected $rules = [ 
        'fecha' => 'required|date',
        'brou' => 'required|numeric',
        'compra' => 'required|numeric',
        'venta' => 'required|numeric'
    ];
    
    public function mount() {
        $this->fecha = now()->toDateString();
        $this->tipo = cache('modoSivezul');
        //$this->brou = 24;
        //dd($this->fecha);
    }

    public function crearDolar() {
        $datos = $this->validate();

        //dd($datos);
        
        // crear el dolar
        Dolar::create([
            'fecha' => $datos['fecha'],
            'brou' => $datos['brou'],
            'compra' => $datos['compra'],
            'venta' => $datos['venta']
        ]);

        // crear un mensaje
        session()->flash('mensaje', 'La cotización se publicó correctamente');

        // redireccionar al usuario
        return redirect()->route('dolares.index');
    }

    public function render()
    {
        //$items = Item::where('todos', '<', 2)->get();
        return view('livewire.crear-dolar');
    }
}
