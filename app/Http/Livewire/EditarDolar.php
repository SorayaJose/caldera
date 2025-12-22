<?php

namespace App\Http\Livewire;

use App\Models\Dolar;
use Livewire\Component;

class EditarDolar extends Component
{
    public $dolar_id;
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
    
    
    public function mount(Dolar $dolar) {
        $this->dolar_id = $dolar->id;
        $this->fecha = $dolar->fecha;
        $this->brou = $dolar->brou;
        $this->compra = $dolar->compra;
        $this->venta = $dolar->venta;
    }

    public function editarDolar() {
        //dd($this->rubro_id);
        $datos = $this->validate();

        // encontrar la persona
        $dolar = Dolar::find($this->dolar_id);

        // asignar nuevos valores
        $dolar->fecha = $datos['fecha'];
        $dolar->brou = $datos['brou'];
        $dolar->compra = $datos['compra'];
        $dolar->venta = $datos['venta'];

        // guardar el registro
        $dolar->save();

        // armar el mensaje
        session()->flash('mensaje', 'La cotización se modificó correctamente');

        // redireccionar al usuario
        return redirect()->route('dolares.index');
    }

    public function render()
    {
        return view('livewire.editar-dolar');
    }
}

