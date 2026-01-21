<?php

namespace App\Http\Livewire;

use App\Models\Movimiento;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarMovimientos extends Component
{
    protected $listeners = ['eliminarMovimiento'];
    public $search;
    public $sort = "fecha";
    public $direction = "asc";
    public $cantidad = 10;
    public $readyToLoad = false;
    public $open = false;

    protected $queryString = [
        'cantidad' => ['except' => 10]
    ];
    use WithPagination;

    public function eliminarMovimiento(Movimiento $movimiento) {
        $movimiento->delete();
        //dd($movimiento);
    }
 
    public function render()
    {
        $tipo = cache('modoSivezul');
        if($this->readyToLoad) {
            $movimientos = Movimiento::
            where('tipo', $tipo)
            //->orwhere('dormitorios', $this->search)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cantidad);
        } else {
            $movimientos = [];
        }

        
        return view('livewire.mostrar-movimientos', compact('movimientos'));
        // ->layout('layouts.base')
        
    }

    public function loadRegistros() {
        $this->readyToLoad = true;
    }

    public function order($sort) {
        
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
