<?php

namespace App\Http\Livewire;

use App\Models\Banco;
use App\Models\Dolar;
use App\Models\Cuenta;
use Livewire\Component;
use App\Models\Movimiento;
use App\Models\Vencimiento;
use Livewire\WithPagination;
use App\Models\TmpMovimiento;
use App\Models\TmpVencimiento;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
//use App\Models\TmpVencimiento;

class MostrarBancosVtos extends Component
{
    protected $listeners = ['moverCosaABanco', 'resetear', 'sacarMovimiento', 
                'sacarVencimiento', 'agregarComentario', 'confirmarMovimiento, 
                confirmarVencimiento'];
    public $search;
    public $sort = "fecha";
    public $direction = "desc";
    public $cantidad = 100;
    public $readyToLoad = false;
    public $open = false;
    public $origen;
    public $importe;
    public $moneda;
    public $destino;
    public $comentario;

    protected $queryString = [
        'cantidad' => ['except' => 10]
    ];
    use WithPagination;

    public function reorder ($orderedIds) {
        dd($orderedIds);
    }

    public function movimiento() {
        if ($this->moneda == null) {
            $this->moneda = '$';
        }

       // dump('Origen: ' . $this->origen . 'Destino: ' . $this->destino . ' Moneda:' . $this->moneda . ' Importe:' . $this->importe);

        if ($this->importe != null) {
            TmpMovimiento::create([
                'mov_tipo' => 'M',
                'moneda' => $this->moneda,
                'importe' => $this->importe,
                'tipo' => cache('modoSivezul'),
                'cuenta_id' => $this->origen,
                'destino' => $this->destino,
                'comentario' => '',
                'fecha' => now()
            ]);


            // calcular nuevo saldo de la cuenta
            $cuenta = Cuenta::find($this->origen);
            //dd($cuenta);
            $nuevo_saldo = $cuenta->saldo_tmp;

            //dump('saldo origen : ' . $nuevo_saldo);

            if ($cuenta->moneda == '$') {
                if ($this->moneda == '$') {
                    $nuevo_saldo -= $this->importe;
                } else {
                    $nuevo_saldo -= $this->pasoAPesos($this->importe);
                }
            } else {
                if ($this->moneda == '$') {
                    $nuevo_saldo -= $this->pasoADolares($this->importe);
                } else {
                    $nuevo_saldo -= $this->importe;
                }
            }
            //dump('saldo origen despues: ' . $nuevo_saldo);

            $cuenta->saldo_tmp = $nuevo_saldo;
            $cuenta->save();

            // calcular nuevo saldo de la cuenta
            $cuenta = Cuenta::find($this->destino);
            $nuevo_saldo = $cuenta->saldo_tmp;
            $this->importe = abs($this->importe);

            //dump('saldo destino : ' . $nuevo_saldo);
            //dump('importe a mover : ' . $this->importe);

            if ($cuenta->moneda == '$') {
                if ($this->moneda == '$') {
                    $nuevo_saldo += $this->importe;
                } else {
                    $nuevo_saldo += $this->pasoAPesos($this->importe);
                }
            } else {
                if ($this->moneda == '$') {
                    $nuevo_saldo += $this->pasoADolares($this->importe);
                } else {
                    $nuevo_saldo += $this->importe;
                }
            }
            //dump('saldo destino : ' . $nuevo_saldo);
            $cuenta->saldo_tmp = $nuevo_saldo;
            $cuenta->save();

            // crear un mensaje
            session()->flash('mensaje', 'El movimiento se realizó correctamente');
            $this->dispatchBrowserEvent('alerta-exitosa', [
                'titulo' => '¡Actualizado!',
                'mensaje' => 'El vencimiento se movió correctamente.',
                'icono' => 'success'
            ]);
        }
    }

    public function agregarComentario() {
        //dd('Comentario: ' . $this->comentario);

        if ($this->comentario != null) {
            TmpMovimiento::create([
                'mov_tipo' => 'C',
                'moneda' => '$',
                'importe' => 0,
                'tipo' => cache('modoSivezul'),
                'cuenta_id' => 0,
                'destino' => 0,
                'fecha' => now(),
                'comentario' => $this->comentario
            ]);

            // crear un mensaje
            session()->flash('mensaje', 'El comentario se agregó correctamente');
            $this->dispatchBrowserEvent('alerta-exitosa', [
                'titulo' => '¡Actualizado!',
                'mensaje' => 'El comentario se agregó correctamente.',
                'icono' => 'success'
            ]);

            $this->comentario = '';
        }
    }

    public function moverCosaABanco($vencimiento_id, $cuenta_id)
    {
        //dd('cosa: ' .$vencimiento_id .' y la cuenta ' . $cuenta_id);
        $vencimiento = Vencimiento::find($vencimiento_id);
        $vencimiento->cuenta_id = $cuenta_id;
        $vencimiento->save();

        TmpVencimiento::create([
            'fecha' => now(),
            'moneda' => $vencimiento->moneda,
            'importe' => $vencimiento->importe,
            'concepto' => 'mov',
            'rubro_id' => $vencimiento->rubro_id,
            'tipo' => cache('modoSivezul'),
            'destino' => 0,
            'cuenta_id' => $vencimiento->cuenta_id,
        ]);

        // calcular nuevo saldo de la cuenta
        $cuenta = Cuenta::find($cuenta_id);
        $nuevo_saldo = $cuenta->saldo_tmp;

        if ($cuenta->moneda == '$') {
            if ($vencimiento->moneda == '$') {
                $nuevo_saldo -= $vencimiento->importe;
            } else {
                $nuevo_saldo -= $this->pasoAPesos($vencimiento->importe);
            }
        } else {
            if ($vencimiento->moneda == '$') {
                $nuevo_saldo -= $this->pasoADolares($vencimiento->importe);
            } else {
                $nuevo_saldo -= $vencimiento->importe;
            }
        }
        $cuenta->saldo_tmp = $nuevo_saldo;
        $cuenta->save();

        session()->flash('mensaje', 'El movimiento se realizó correctamente');
        $this->dispatchBrowserEvent('alerta-exitosa', [
            'titulo' => '¡Actualizado!',
            'mensaje' => 'El vencimiento se movió correctamente.',
            'icono' => 'success'
        ]);
    }

    public function confirmarVencimiento($vencimiento_id) {
        dd('entro en confirmar vencimiento ' . $vencimiento_id);
    }

    public function confirmarMovimiento($movimiento_id) {
        dd('entro en confirmar movimiento ' . $movimiento_id);
    }

    public function sacarVencimiento($vencimiento_id) {
        //dd('entro en sacar vencimiento ' . $vencimiento_id);
        $vencimiento = Vencimiento::find($vencimiento_id);

        $cuenta_id = $vencimiento->cuenta_id;
        $vencimiento->cuenta_id = 0;
        $vencimiento->save();

        $cuenta = Cuenta::find($cuenta_id);
        $nuevo_saldo = $cuenta->saldo_tmp;

        if ($cuenta->moneda == '$') {
            if ($vencimiento->moneda == '$') {
                $nuevo_saldo += $vencimiento->importe;
            } else {
                $nuevo_saldo += $this->pasoAPesos($vencimiento->importe);
            }
        } else {
            if ($vencimiento->moneda == '$') {
                $nuevo_saldo += $this->pasoADolares($vencimiento->importe);
            } else {
                $nuevo_saldo += $vencimiento->importe;
            }
        }
        $cuenta->saldo_tmp = $nuevo_saldo;
        $cuenta->save();
    }

    public function sacarMovimiento($id) {
        //dd('entro en sacar vencimiento ' . $id);
        $mov = TmpMovimiento::find($id);
        if ($mov->mov_tipo == 'M') {
            // eliminar un movimiento
            // volver a agregar el saldo del importe del movimiento
            //dump('Origen: ' . $this->origen . 'Destino: ' . $this->destino . ' Moneda:' . $this->moneda . ' Importe:' . $this->importe);

            if ($mov->importe != null) {

                // calcular nuevo saldo de la cuenta
                $cuenta = Cuenta::find($mov->cuenta_id);
                //dd($cuenta);
                $nuevo_saldo = $cuenta->saldo_tmp;
    
                //dump('saldo origen : ' . $nuevo_saldo);
    
                if ($cuenta->moneda == '$') {
                    if ($mov->moneda == '$') {
                        $nuevo_saldo += $mov->importe;
                    } else {
                        $nuevo_saldo += $this->pasoAPesos($mov->importe);
                    }
                } else {
                    if ($mov->moneda == '$') {
                        $nuevo_saldo += $this->pasoADolares($mov->importe);
                    } else {
                        $nuevo_saldo += $mov->importe;
                    }
                }
                //dump('saldo origen despues: ' . $nuevo_saldo);
    
                $cuenta->saldo_tmp = $nuevo_saldo;
                $cuenta->save();
    
                // calcular nuevo saldo de la cuenta
                $cuenta = Cuenta::find($mov->destino);
                $nuevo_saldo = $cuenta->saldo_tmp;
                $mov->importe = abs($mov->importe);
    
                //dump('saldo destino : ' . $nuevo_saldo);
                //dump('importe a mover : ' . $this->importe);
    
                if ($cuenta->moneda == '$') {
                    if ($mov->moneda == '$') {
                        $nuevo_saldo -= $mov->importe;
                    } else {
                        $nuevo_saldo -= $this->pasoAPesos($mov->importe);
                    }
                } else {
                    if ($this->moneda == '$') {
                        $nuevo_saldo -= $this->pasoADolares($mov->importe);
                    } else {
                        $nuevo_saldo -= $mov->importe;
                    }
                }
                //dump('saldo destino : ' . $nuevo_saldo);
                $cuenta->saldo_tmp = $nuevo_saldo;
                $cuenta->save();
            }
        } 
        $mov->delete();
    }

    public function pasoAPesos($importe) {
        $dolar = Dolar::whereDate('fecha', '<=', Carbon::today())
        ->orderBy('fecha', 'desc')
        ->orderBy('id', 'desc')
        ->first();
        return $importe * $dolar->brou;
    }

    public function pasoADolares($importe) {
        $dolar = Dolar::whereDate('fecha', '<=', Carbon::today())
        ->orderBy('fecha', 'desc')
        ->orderBy('id', 'desc')
        ->first();
        return $importe / $dolar->brou;
    }
    
    public function resetear() {
        //dd('entro en resetear');
        $tipo = (string) cache('modoSivezul');
        Vencimiento::where('tipo', $tipo)->update(['cuenta_id' => 0]);
        TmpVencimiento::where('tipo', $tipo)->delete();
        TmpMovimiento::where('tipo', $tipo)->delete();
        Cuenta::where('tipo', $tipo)->update(['saldo_tmp' => 0]);
    }
    
    public function render()
    {    
        $tipo = cache('modoSivezul');
        if($this->readyToLoad) {
            $bancos = Banco::where('tipo', $tipo)
            //->orwhere('moneda', $this->search)
            ->orderBy('nombre', 'asc')
            ->orderBy('moneda', 'asc')
            ->paginate($this->cantidad);

            $hoy = Carbon::today();
            $fechaLimite = $hoy->copy();
            
            do {
                $fechaLimite->addDay();
            } while ($fechaLimite->isWeekend());
            
            // Traer todo hasta el próximo día hábil (inclusive)
            //    ->where('fecha', '<=', $fechaLimite)
            $vencimientos = Vencimiento::where('tipo', $tipo)
                ->where('cuenta_id', 0)

                ->orderBy('fecha', 'asc')
                ->paginate($this->cantidad);

            $vencimientos2 = Vencimiento::where('tipo', $tipo)
                ->where('cuenta_id', '!=', 0)
                ->orderBy('cuenta_id', 'asc')
                ->paginate($this->cantidad);
                
            $tmp_movimientos = TmpMovimiento::where('tipo', $tipo)
            //->orwhere('moneda', $this->search)
            //->orderBy($this->sort, $this->direction)
            ->paginate($this->cantidad);
            //dd($tmps);
            //dd($tmp_vencimientos);

            $cuentas = Cuenta::where('tipo', $tipo)
            //->orwhere('moneda', $this->search)
            ->orderBy('banco_id', 'asc')
            ->orderBy('moneda', 'desc')
            ->paginate($this->cantidad);
        } else {
            $bancos = [];
            $vencimientos = [];
            $vencimientos2 = [];
            $tmp_movimientos = [];
            $cuentas = [];
        }


        //$tmp_vencimientos = [1, 2, 3];
        //dd($tmp_vencimientos);
        return view('livewire.mostrar-bancos-vtos4', compact('bancos', 'vencimientos', 'vencimientos2', 'tmp_movimientos', 'cuentas'));   
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

