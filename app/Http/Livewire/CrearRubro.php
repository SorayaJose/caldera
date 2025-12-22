<?php

namespace App\Http\Livewire;

use App\Models\Rubro;
use App\Models\Banco;
use Livewire\Component;

class CrearRubro extends Component
{
    public $nombre;
    public $moneda;
    public $tipo;
    public $banco;
    public $color;

    protected $rules = [
        'nombre' => 'required|string',
        'moneda' => 'nullable',
        'tipo' => 'nullable',
        'color' => 'nullable',
        'banco' => 'numeric|nullable',
    ];
    
    public function mount() {
        $this->nombre = "";
        $this->moneda = "";
        $this->tipo = cache('modoSivezul');
        $this->banco = "";
    }

    public function crearRubro() {
        $datos = $this->validate();

        //dd($datos);
        
        // crear el rubro
        Rubro::create([
            'nombre' => $datos['nombre'],
            'moneda' => $datos['moneda'],
            'tipo' => cache('modoSivezul'),
            'color' => $datos['color'],
            'banco_id' => $datos['banco']
        ]);

        // crear un mensaje
        session()->flash('mensaje', 'El concepto se publicó correctamente');

        // redireccionar al usuario
        return redirect()->route('rubros.index');
    }

    public function render()
    {
        $tipo = cache('modoSivezul');
        //dd($tipo);
        $bancos = Banco::where('tipo', $tipo)->get();

        //dd($bancos);
        return view('livewire.crear-rubro', [
            'bancos_base' => $bancos
        ]);
    }
}
