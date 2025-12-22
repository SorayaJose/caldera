<?php

namespace App\Http\Livewire;

use App\Models\Banco;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarBancos extends Component
{
    protected $listeners = ['eliminarBanco'];
    public $search;
    public $sort = "nombre";
    public $direction = "asc";
    public $cantidad = 10;
    public $readyToLoad = false;
    public $open = false;

    protected $queryString = [
        'cantidad' => ['except' => 10]
    ];
    use WithPagination;

    public function eliminarBanco(Banco $banco) {
        $banco->delete();
        //dd($banco);
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
        
        if($this->readyToLoad) {
            $bancos = Banco::where('nombre', 'like', '%' . $this->search . '%')
            ->where('tipo', $tipo)
            //->orwhere('moneda', $this->search)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cantidad);
        } else {
            $bancos = [];
        }

        return view('livewire.mostrar-bancos', compact('bancos'));
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
