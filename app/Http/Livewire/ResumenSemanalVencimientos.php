<?php

namespace App\Http\Livewire;

use App\Models\Cheque;
use App\Models\Cuenta;
use App\Models\Prestamo;
use App\Models\Vencimiento;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ResumenSemanalVencimientos extends Component
{
    public $semanaInicio; // string Y-m-d
    public $semanaFin;    // string Y-m-d

    private function resolverFecha($valor)
    {
        if (!$valor) {
            return null;
        }

        try {
            return Carbon::parse($valor);
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function cuentaSinEstimarId(string $moneda): string
    {
        return 'sin_estimar_' . ($moneda === 'U$S' ? 'usd' : 'pesos');
    }

    private function cuentaResumenId($cuentaId, string $moneda)
    {
        return $cuentaId ?: $this->cuentaSinEstimarId($moneda);
    }

    private function construirItemsResumen(string $tipo)
    {
        $desde = $this->semanaInicio;
        $hasta = $this->semanaFin;

        $vencimientos = Vencimiento::with('rubro')
            ->where('tipo', $tipo)
            ->whereDate('fecha', '>=', $desde)
            ->whereDate('fecha', '<=', $hasta)
            ->get()
            ->map(function ($v) {
                return (object) [
                    'fecha' => Carbon::parse($v->fecha),
                    'cuenta_resumen_id' => $this->cuentaResumenId($v->cuenta_estimada_id, $v->moneda),
                    'moneda' => $v->moneda,
                    'importe' => (float) $v->importe,
                    'total_pagado' => $v->fecha_pago ? (float) $v->importe : 0.0,
                    'fecha_pago' => $v->fecha_pago ? Carbon::parse($v->fecha_pago) : null,
                    'rubro' => $v->rubro,
                    'comentario' => $v->comentario,
                ];
            });

        $prestamos = Prestamo::where('tipo', $tipo)
            ->whereDate('vencimiento', '>=', $desde)
            ->whereDate('vencimiento', '<=', $hasta)
            ->get()
            ->map(function ($p) {
                return (object) [
                    'fecha' => Carbon::parse($p->vencimiento),
                    'cuenta_resumen_id' => $this->cuentaResumenId($p->cuenta_id, $p->moneda),
                    'moneda' => $p->moneda,
                    'importe' => (float) $p->importe,
                    'total_pagado' => 0.0,
                    'fecha_pago' => null,
                    'rubro' => (object) ['nombre' => 'Préstamo cuota ' . $p->cuota],
                    'comentario' => $p->comentario,
                ];
            });

        $cheques = Cheque::with('cuenta')
            ->where('tipo', $tipo)
            ->whereDate('fecha_pago', '>=', $desde)
            ->whereDate('fecha_pago', '<=', $hasta)
            ->get()
            ->map(function ($c) {
                $moneda = $c->cuenta?->moneda ?? '$';

                return (object) [
                    'fecha' => Carbon::parse($c->fecha_pago),
                    'cuenta_resumen_id' => $this->cuentaResumenId($c->cuenta_id, $moneda),
                    'moneda' => $moneda,
                    'importe' => (float) $c->importe,
                    'total_pagado' => $c->estado === 'pagado' ? (float) $c->importe : 0.0,
                    'fecha_pago' => $c->estado === 'pagado' ? Carbon::parse($c->fecha_pago) : null,
                    'rubro' => (object) ['nombre' => 'Cheque Nº ' . $c->numero_cheque],
                    'comentario' => $c->comentario,
                ];
            });

        return $vencimientos
            ->concat($prestamos)
            ->concat($cheques);
    }

    public function mount()
    {
        $inicioRequest = $this->resolverFecha(request()->query('semanaInicio'));
        $finRequest = $this->resolverFecha(request()->query('semanaFin'));

        if ($inicioRequest) {
            $inicio = $inicioRequest->copy()->startOfDay();
            $fin = $finRequest ? $finRequest->copy()->endOfDay() : $inicioRequest->copy()->endOfWeek(Carbon::SUNDAY);

            $this->semanaInicio = $inicio->toDateString();
            $this->semanaFin = $fin->toDateString();

            return;
        }

        $this->semanaInicio = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $this->semanaFin    = Carbon::now()->endOfWeek(Carbon::SUNDAY)->toDateString();
    }

    public function semanaSiguiente()
    {
        $this->semanaInicio = Carbon::parse($this->semanaInicio)->addWeek()->toDateString();
        $this->semanaFin    = Carbon::parse($this->semanaFin)->addWeek()->toDateString();
    }

    public function semanaAnterior()
    {
        $this->semanaInicio = Carbon::parse($this->semanaInicio)->subWeek()->toDateString();
        $this->semanaFin    = Carbon::parse($this->semanaFin)->subWeek()->toDateString();
    }

    public function semanaActual()
    {
        $this->semanaInicio = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $this->semanaFin    = Carbon::now()->endOfWeek(Carbon::SUNDAY)->toDateString();
    }

    public function render()
    {
        $tipo = cache('modoSivezul');

        // Todas las cuentas del modo activo, siempre visibles
        $cuentasReales = Cuenta::where('tipo', $tipo)
            ->with('banco')
            ->orderBy('banco_id')
            ->orderBy('moneda', 'desc')
            ->get();

        $cuentasVirtuales = collect(['U$S', '$'])->map(function ($moneda) {
            return (object) [
                'id' => $this->cuentaSinEstimarId($moneda),
                'moneda' => $moneda,
                'numero' => null,
                'banco' => (object) ['nombre' => 'Sin estimar'],
            ];
        });

        $cuentas = $cuentasReales->concat($cuentasVirtuales);

        $itemsResumen = $this->construirItemsResumen($tipo);

        // Totales por fecha + cuenta
        $rows = $itemsResumen
            ->groupBy(fn($item) => $item->fecha->toDateString())
            ->map(function ($grupoPorFecha) {
                return $grupoPorFecha
                    ->groupBy('cuenta_resumen_id')
                    ->map(function ($itemsCuenta) {
                        $primero = $itemsCuenta->first();

                        return (object) [
                            'fecha' => $primero->fecha,
                            'cuenta_estimada_id' => $primero->cuenta_resumen_id,
                            'moneda' => $primero->moneda,
                            'total' => $itemsCuenta->sum('importe'),
                            'total_pagado' => $itemsCuenta->sum('total_pagado'),
                        ];
                    });
            });

        // Detalle individual para tooltips (agrupado por fecha → cuenta)
        $detalles = $itemsResumen
            ->sortByDesc('importe')
            ->groupBy(fn($item) => $item->fecha->toDateString())
            ->map(function ($grupoPorFecha) {
                return $grupoPorFecha->groupBy('cuenta_resumen_id');
            });

        // Generar todos los días de la semana (lun→dom)
        $dias = collect();
        $cursor = Carbon::parse($this->semanaInicio);
        while ($cursor->lte(Carbon::parse($this->semanaFin))) {
            $dias->push($cursor->copy());
            $cursor->addDay();
        }

        // Totales por cuenta (fila → total semana)
        $totalesPorCuenta = [];
        foreach ($cuentas as $cuenta) {
            $total = 0;
            foreach ($dias as $dia) {
                $key   = $dia->toDateString();
                $celda = $rows->get($key)?->get($cuenta->id);
                if ($celda) $total += $celda->total;
            }
            $totalesPorCuenta[$cuenta->id] = $total;
        }

        // Subtotales por moneda y día (para filas de subtotal de grupo)
        $subtotalesPorDia   = ['U$S' => [], '$' => []];
        $subtotalesSemana   = ['U$S' => 0, '$' => 0];
        foreach (['U$S', '$'] as $moneda) {
            $cuentasMoneda = $cuentas->where('moneda', $moneda);
            foreach ($dias as $dia) {
                $key   = $dia->toDateString();
                $suma  = 0;
                foreach ($cuentasMoneda as $c) {
                    $celda = $rows->get($key)?->get($c->id);
                    if ($celda) $suma += $celda->total;
                }
                $subtotalesPorDia[$moneda][$key] = $suma;
                $subtotalesSemana[$moneda] += $suma;
            }
        }

        return view('livewire.resumen-semanal-vencimientos', [
            'dias'               => $dias,
            'cuentas'            => $cuentas,
            'rows'               => $rows,
            'detalles'           => $detalles,
            'totalesPorCuenta'   => $totalesPorCuenta,
            'subtotalesPorDia'   => $subtotalesPorDia,
            'subtotalesSemana'   => $subtotalesSemana,
            'hoy'                => Carbon::today()->toDateString(),
        ]);
    }
}
