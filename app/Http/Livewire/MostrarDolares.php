<?php

namespace App\Http\Livewire;

use App\Models\Dolar;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarDolares extends Component
{
    protected $listeners = ['eliminarDolar'];
    public $search;
    public $sort = "fecha";
    public $direction = "desc";
    public $cantidad = 10;
    public $readyToLoad = false;
    public $open = false;

    protected $queryString = [
        'cantidad' => ['except' => 10]
    ];
    use WithPagination;

    public function eliminarDolar(Dolar $dolar) {
        $dolar->delete();
        //dd($banco);
    }
 
    public function render()
    {
    
        if($this->readyToLoad) {
            $dolares = Dolar::orderBy($this->sort, $this->direction)
            ->paginate($this->cantidad);
        } else {
            $dolares = [];
        }

        return view('livewire.mostrar-dolares', compact('dolares'));   
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

