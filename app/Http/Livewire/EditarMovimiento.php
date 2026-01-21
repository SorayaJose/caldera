<?php

namespace App\Http\Livewire;

use App\Models\Rubro;
use Livewire\Component;
use App\Models\Movimiento;

class EditarMovimiento extends Component
{
    public $movimiento_id;
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

    public function mount(Movimiento $movimiento) {
        //dd($movimiento);
        $this->movimiento_id = $movimiento->id;
        $this->fecha = $movimiento->fecha;
        $this->moneda = $movimiento->moneda;
        $this->tipo = cache('modoSivezul');
        $this->importe = $movimiento->importe; 
        $this->rubro = $movimiento->rubro_id; 
    }

    
    public function editarMovimiento() {
        $datos = $this->validate();
//        dd($datos['items']);

        // encontrar la vacante
        $movimiento = Movimiento::find($this->movimiento_id);

        // asignar nuevos valores
        $movimiento->fecha  = $datos['fecha'];
        $movimiento->tipo = $datos['tipo'];
        $movimiento->moneda = $datos['moneda'];
        $movimiento->importe = $datos['importe'];  
        $movimiento->rubro_id = $datos['rubro'];

        // guardar el movimiento
        $movimiento->save();

        // armar el mensaje
        session()->flash('mensaje', 'El movimiento se modificó correctamente');

        // redireccionar al usuario
        return redirect()->route('movimientos.index');
    }
    
    public function render() {
        $rubros = Rubro::get();
        //dd($items);
        return view('livewire.editar-movimiento', [
            'rubros' => $rubros
        ]);
    }
}
