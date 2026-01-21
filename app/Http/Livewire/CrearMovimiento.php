<?php

namespace App\Http\Livewire;

use App\Models\Rubro;
use Livewire\Component;
use App\Models\Movimiento;

class CrearMovimiento extends Component
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

    public function crearMovimiento() {
        $datos = $this->validate();

        //dd($datos);

        // crear el movimiento
        Movimiento::create([
            'fecha' => $datos['fecha'],
            'tipo' => $datos['tipo'],
            'moneda' => $datos['moneda'],
            'importe' => $datos['importe'],
            'tipo' => $datos['tipo'],
            'cuenta_id' => $datos['cuenta'],
            'vencimiento_id' => $datos['vencimiento'],
            'destino' => $datos['destino'],
        ]);

        // crear un mensaje
        session()->flash('mensaje', 'El movimiento se publicó correctamente');

        // redireccionar al usuario
        return redirect()->route('movimientos.index');
    }

    public function render()
    {
        $rubros = Rubro::get();
        //dd($items);
        return view('livewire.crear-movimiento', [
            'rubros' => $rubros
        ]);
    }
}

