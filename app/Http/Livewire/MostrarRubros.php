<?php

namespace App\Http\Livewire;

use App\Models\Rubro;
use Livewire\Component;
use App\Models\Vencimiento;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MostrarRubros extends Component
{
    protected $listeners = ['eliminarRubro'];
    public $search;
    public $sort = "nombre";
    public $todos = '';
    public $direction = "asc";
    public $cantidad = 10;
    public $readyToLoad = false;
    public $open = false;

    protected $queryString = [
        'cantidad' => ['except' => 10]
    ];
    use WithPagination;

    public function eliminarRubro(Rubro $rubro) {
        $rubro->delete();
        //dd($rubro);
    }
 
    public function render()
    {
        /*
        $filePath = storage_path('tmp.csv');
        
        if (file_exists($filePath)) {
            $handle = fopen($filePath, 'r');
        
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    // Procesa cada línea
                    $valores = str_getcsv($line, ';');
                    
                    //print_r($valores);
                    $fecha = Carbon::createFromFormat('d/m/y', $valores[0])->format('Y-m-d');
                    $dolares = $valores[1];
                    $pesos = $valores[2];
                    $nombre_rubro = $valores[3];
                    $concepto = $valores[4];
                    $color = $valores[5];
                    $moneda = 'U$S';
                    $importe = $dolares;
                    if ($pesos >= 0) {
                        $moneda = '$';
                        $importe = $pesos;
                    }

                    echo $fecha . "<BR>";
                    echo 'dolares $dolares <BR>';
                    echo 'pesos $pesos <BR>';
                    echo "nombre $nombre_rubro <BR>";
                    echo "concepto: $concepto<BR>";
                    echo "color: $color<BR>";

                    $rubro_encontrado = Rubro::where('nombre', $nombre_rubro)->first();
                    $tmp_rubro = 0;
                    if ($rubro_encontrado != null) {
                        $tmp_rubro = $rubro_encontrado->id;
                        
                    } else {
                        Rubro::create([
                            'nombre' => $nombre_rubro,
                            'moneda' => $moneda,
                            'tipo' => 'S',
                            'color' => $color
                        ]);
        
                        // Obtener el mayor rubro_id
                        $tmp_rubro = Rubro::max('id');
                    }
                    echo "encontro $tmp_rubro <br>";

                    Vencimiento::create([
                        'fecha' => $fecha,
                        'moneda' => $moneda,
                        'importe' => $importe,
                        'concepto' => $concepto,
                        'rubro_id' => $tmp_rubro,
                        'tipo' => 'S'
                    ]);

                    echo "<BR>";
                }

                fclose($handle);
            } else {
                // Error al abrir el archivo
                echo "No se pudo abrir el archivo.";
            }
        } else {
            echo "Archivo no encontrado.";
        }

        $valores = DB::table('tmp_sivezul')->get();
        //dd($valores);
        $i = 1;
        foreach($valores as $valor) {
            //var_dump($valor);
            echo "<br><br>";

            $fecha = $valor->fecha;
            $pesos = $valor->pesos;
            $dolares = $valor->dolares;
            $concepto = $valor->concepto;
            $tipo = $valor->tipo;
            $moneda = '$';
            if ($pesos < 1) {
                $moneda = 'U$S';
            }
            echo "Concepto: $i - $concepto - $tipo <br>";
            echo "Vencimiento: $fecha - $pesos - $dolares - $moneda<br>";
            
            //
            //Rubro::create([
            //    'nombre' => $concepto,
            //    'moneda' => $moneda,
            //    'tipo' => $tipo
            //]);
            //$id_rubro = Rubro::select('id')->orderBy('id', 'desc')->first();
            //echo "ID: $id_rubro <br>";
            
            
            $i++;
        }
        */

        $tipo = cache('modoSivezul');
        
        if($this->readyToLoad) {
            $rubros = Rubro::where('nombre', 'like', '%' . $this->search . '%')
            ->where('tipo', $tipo)
            //->orwhereHas('banco', function ($query) {
            //    $query->where('nombre', 'like', '%' . $this->search . '%');
            // })
            //->orwhere('moneda', $this->search)
            ->orderBy($this->sort, $this->direction)
            ->paginate($this->cantidad);
        } else {
            $rubros = [];
        }

        return view('livewire.mostrar-rubros', compact('rubros'));
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
