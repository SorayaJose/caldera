<?php

namespace App\Http\Livewire;

use App\Models\Vencimiento;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarVencimientos extends Component
{
    protected $listeners = ['eliminarVencimiento'];
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

    public function eliminarVencimiento(Vencimiento $vencimiento) {
        $vencimiento->delete();
        //dd($vencimiento);
    }

    public function render()
    {
        $tipo = cache('modoSivezul');
        if($this->readyToLoad) {
            $vencimientos = Vencimiento::
            where('tipo', $tipo)
            //->orwhere('dormitorios', $this->search)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cantidad);
        } else {
            $vencimientos = [];
        }

        return view('livewire.mostrar-vencimientos', compact('vencimientos'));
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
