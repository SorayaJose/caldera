<?php

namespace App\Http\Livewire;

use App\Models\Rubro;
use Livewire\Component;
use App\Models\Vencimiento;

class EditarVencimiento extends Component
{
    public $vencimiento_id;
    public $fecha;
    public $moneda;
    public $importe;
    //public $concepto;
    public $rubro;
    public $tipo;

    protected $rules = [
        'fecha' => 'date|nullable',
        'moneda' => 'nullable',
        'importe' => 'numeric|required',
        //'concepto' => 'required|string',
        'rubro' => 'nullable',
        'tipo' => 'nullable'
    ];

    public function mount(Vencimiento $vencimiento) {
        //dd($vencimiento);
        $this->vencimiento_id = $vencimiento->id;
        $this->fecha = $vencimiento->fecha;
        $this->moneda = $vencimiento->moneda;
        $this->tipo = cache('modoSivezul');
        $this->importe = $vencimiento->importe; 
        $this->rubro = $vencimiento->rubro_id; 
    }

    
    public function editarVencimiento() {
        $datos = $this->validate();
//        dd($datos['items']);

        // encontrar la vacante
        $vencimiento = Vencimiento::find($this->vencimiento_id);

        // asignar nuevos valores
        $vencimiento->fecha  = $datos['fecha'];
        $vencimiento->tipo = $datos['tipo'];
        $vencimiento->moneda = $datos['moneda'];
        $vencimiento->importe = $datos['importe'];  
        $vencimiento->rubro_id = $datos['rubro'];

        // guardar el vencimiento
        $vencimiento->save();

        // armar el mensaje
        session()->flash('mensaje', 'El vencimiento se modificó correctamente');

        // redireccionar al usuario
        return redirect()->route('vencimientos.index');
    }
    
    public function render() {
        $rubros = Rubro::get();
        //dd($items);
        return view('livewire.editar-vencimiento', [
            'rubros' => $rubros
        ]);
    }
}
