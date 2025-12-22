<?php

namespace App\Http\Livewire;

use App\Models\Cuenta;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarCuentas extends Component
{
    protected $listeners = ['eliminarCuenta'];
    public $search;
    public $sort = "banco";
    public $direction = "asc";
    public $cantidad = 10;
    public $readyToLoad = false;
    public $open = false;

    public $valores = [];
    public $valor;

    protected $queryString = [
        'cantidad' => ['except' => 10]
    ];
    use WithPagination;

    public function eliminarCuenta(Cuenta $cuenta)
    {
        $cuenta->delete();
        //dd($cuenta);
    }

    public function actualizarValor($id)
    {
        $valor = $this->valores[$id] ?? null;
    
        $this->validate([
            "valores.$id" => 'required|numeric'
        ], [
            "valores.$id.required" => 'El saldo no puede estar vacío.',
            "valores.$id.numeric"  => 'El saldo debe ser un número válido.'
        ]);
    
        $cuenta = Cuenta::find($id);
    
        if ($cuenta) {
            $cuenta->saldo = $valor;
            $cuenta->save();
    
            // Limpiar solo este input
            $this->valores[$id] = '';
    
            $this->dispatchBrowserEvent('swal:ok', [
                'title' => 'Saldo actualizado',
                'text'  => 'El nuevo saldo se guardó correctamente',
                'icon'  => 'success',
            ]);
        }
    }

    public function render()
    {
        /*
        $apartamentos = Apartamento::all();
        foreach($apartamentos as $apto) {
            echo "Apto: " . $apto->id . "-". $apto->nombre . " OSE " .  $apto->contador_ose . "<br>";
            if ($apto->contador_ose != '') {
                $rubro = Rubro::where('nombre', 'Ose contador: '.trim($apto->contador_ose))->first();
                if ($rubro != '') {
                    $apto->rubros()->attach($rubro->id);
                    echo $rubro->id . "---------------------<br>";
                }
            }
        }
        echo "estoy aca";
        dd("ahora");
        */
        $tipo = cache('modoSivezul');

        if ($this->readyToLoad) {
            $cuentas = Cuenta::where('tipo', $tipo)
                //->orwhere('moneda', $this->search)
                ->orderBy('banco_id', $this->direction)
                ->orderBy('moneda', $this->direction)
                ->paginate($this->cantidad);
        } else {
            $cuentas = [];
        }

        return view('livewire.mostrar-cuentas', compact('cuentas'));
        // ->layout('layouts.base')

    }

    public function loadRegistros()
    {
        $this->readyToLoad = true;
    }

    public function order($sort)
    {

        if ($this->sort == $sort) {
            if ($this->direction == "desc") {
                $this->direction = "asc";
            } else {
                $this->direction = "desc";
            }
        } else {
            $this->sort = $sort;
            $this->direction = "asc";
        }
    }
}
