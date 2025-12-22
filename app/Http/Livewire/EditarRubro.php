<?php

namespace App\Http\Livewire;

use App\Models\Banco;
use App\Models\Rubro;
use Livewire\Component;

class EditarRubro extends Component
{
    public $rubro_id;
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
        'banco' => 'numeric|nullable'
    ];
    
    public function mount(Rubro $rubro) {
        $this->rubro_id = $rubro->id;
        $this->nombre = $rubro->nombre;
        $this->moneda = $rubro->moneda;
        $this->color = $rubro->color;
        $this->banco = $rubro->banco;
        $this->tipo = $rubro->tipo;
    }

    public function editarRubro() {
        //dd($this->rubro_id);
        $datos = $this->validate();

        // encontrar el rubro
        $rubro = Rubro::find($this->rubro_id);

        // asignar nuevos valores
        $rubro->nombre  = $datos['nombre'];
        $rubro->moneda  = $datos['moneda'];
        $rubro->tipo  = cache('modoSivezul');
        $rubro->color = $datos['color'];
        $rubro->banco_id = $datos['banco'];
        
        // guardar el registro
        $rubro->save();

        // armar el mensaje
        session()->flash('mensaje', 'El concepto se modificó correctamente');

        // redireccionar al usuario
        return redirect()->route('rubros.index');
    }

    public function render()
    {
        $tipo = cache('modoSivezul');
        $bancos = Banco::where('tipo', $tipo)->get();

        //dd($bancos);
        return view('livewire.editar-rubro', [
            'bancos_base' => $bancos
        ]);
    }
}
