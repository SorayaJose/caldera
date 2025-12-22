<?php

namespace App\Http\Livewire;

use App\Models\Rubro;
use Livewire\Component;
use App\Models\Vencimiento;

class CrearVencimiento extends Component
{
    public $fecha;
    public $moneda;
    public $importe;
    public $concepto;
    public $rubro;
    public $tipo;


    protected $rules = [
        'fecha' => 'date|nullable',
        'moneda' => 'nullable',
        'importe' => 'numeric|required',
        //'concepto' => 'required|string',
        'rubro' => 'numeric',
        'tipo' => 'nullable'
    ];

    public function mount() {
        //$this->concepto = "";
        $this->moneda = "";
        $this->importe = "";
        $this->tipo = cache('modoSivezul');
    }

    public function crearVencimiento() {
        $datos = $this->validate();

        //dd($datos);
        
        // crear el vencimiento
        Vencimiento::create([
            'fecha' => $datos['fecha'],
            'moneda' => $datos['moneda'],
            'importe' => $datos['importe'],
            //'concepto' => $datos['concepto'],
            'rubro_id' => $datos['rubro'],
            'tipo' => $datos['tipo'],
        ]);

        // crear un mensaje
        session()->flash('mensaje', 'El vencimiento se publicó correctamente');

        // redireccionar al usuario
        return redirect()->route('vencimientos.index');
    }

    public function render()
    {
        $rubros = Rubro::get();
        //dd($items);
        return view('livewire.crear-vencimiento', [
            'rubros' => $rubros
        ]);
    }
}

