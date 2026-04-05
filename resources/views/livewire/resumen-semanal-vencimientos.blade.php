<div>
    @php
        $iconosBanco = [
            'HSBC' => 'hsbc.png',
            'Scotiabank' => 'scotiabank.png',
            'Santander' => 'santander.png',
            'BROU' => 'brou.png',
            'BBVA' => 'bbva.png',
            'Itaú' => 'itau.png',
            'Caja' => null,
        ];
    @endphp
    @php
        $semanaAnteriorInicio = \Carbon\Carbon::parse($semanaInicio)->subWeek()->toDateString();
        $semanaAnteriorFin = \Carbon\Carbon::parse($semanaFin)->subWeek()->toDateString();
        $semanaSiguienteInicio = \Carbon\Carbon::parse($semanaInicio)->addWeek()->toDateString();
        $semanaSiguienteFin = \Carbon\Carbon::parse($semanaFin)->addWeek()->toDateString();
        $semanaActualInicio = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->toDateString();
        $semanaActualFin = \Carbon\Carbon::now()->endOfWeek(\Carbon\Carbon::SUNDAY)->toDateString();
    @endphp
    {{-- Navegación de semana --}}
    <div class="flex items-center gap-3 mb-5">
        <a href="{{ route('vencimientos.resumen', ['semanaInicio' => $semanaAnteriorInicio, 'semanaFin' => $semanaAnteriorFin]) }}"
                class="inline-flex px-3 py-1.5 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition">
            ← Sem. anterior
        </a>
        <a href="{{ route('vencimientos.resumen', ['semanaInicio' => $semanaActualInicio, 'semanaFin' => $semanaActualFin]) }}"
                class="inline-flex px-3 py-1.5 rounded-md bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-medium transition">
            Hoy
        </a>
        <a href="{{ route('vencimientos.resumen', ['semanaInicio' => $semanaSiguienteInicio, 'semanaFin' => $semanaSiguienteFin]) }}"
                class="inline-flex px-3 py-1.5 rounded-md bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium transition">
            Sem. siguiente →
        </a>
        <span class="ml-2 text-sm text-gray-500">
            {{ \Carbon\Carbon::parse($semanaInicio)->locale('es')->isoFormat('D MMM') }}
            –
            {{ \Carbon\Carbon::parse($semanaFin)->locale('es')->isoFormat('D MMM YYYY') }}
        </span>
        <div wire:loading class="ml-2 text-xs text-indigo-400 italic">Cargando...</div>
    </div>

    @if($cuentas->isEmpty())
        <div class="bg-white rounded-lg border border-gray-200 p-8 text-center text-gray-400 text-sm">
            No hay cuentas configuradas para este modo.
        </div>
    @else
        {{-- Tabla --}}
        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
            <table class="w-full text-sm bg-white divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide w-40">
                            Cuenta
                        </th>
                        @foreach($dias as $dia)
                            @php $esHoy = $dia->toDateString() === $hoy; @endphp
                            <th class="px-3 py-3 text-center text-xs font-semibold uppercase tracking-wide
                                {{ $esHoy ? 'bg-indigo-100 text-indigo-700' : ($dia->isWeekend() ? 'text-gray-400' : 'text-gray-600') }}">
                                <span class="block">{{ $dia->locale('es')->isoFormat('ddd') }}</span>
                                <span class="block font-normal normal-case">{{ $dia->locale('es')->isoFormat('D/M') }}</span>
                            </th>
                        @endforeach
                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach(['U$S', '$'] as $moneda)
                        @php $cuentasGrupo = $cuentas->where('moneda', $moneda); @endphp
                        @if($cuentasGrupo->isNotEmpty())
                            {{-- Encabezado de grupo --}}
                            <tr class="bg-gray-100">
                                <td colspan="{{ count($dias) + 2 }}"
                                    class="px-4 py-1.5 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ $moneda === 'U$S' ? 'Dólares (U$S)' : 'Pesos ($)' }}
                                </td>
                            </tr>
                            {{-- Filas de cuentas --}}
                            @foreach($cuentasGrupo as $cuenta)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        @php
                                            $nombreBanco = $cuenta->banco->nombre;
                                            $iconoBanco = $iconosBanco[$nombreBanco] ?? null;
                                        @endphp
                                        <div class="flex items-center gap-2">
                                            @if($nombreBanco === 'Sin estimar')
                                                <span class="inline-flex items-center justify-center h-7 w-7 rounded-full border border-dashed border-amber-400 bg-amber-50 text-[10px] font-bold text-amber-700 shrink-0" style="width:1.75rem;height:1.75rem;max-width:1.75rem;line-height:1;">
                                                    SE
                                                </span>
                                            @elseif($iconoBanco)
                                                <img src="{{ asset($iconoBanco) }}" alt="{{ $nombreBanco }}" class="h-7 w-7 object-contain shrink-0" style="width:1.75rem;height:1.75rem;max-width:1.75rem;object-fit:contain;display:block;" />
                                            @elseif($nombreBanco === 'Caja')
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7 text-gray-700 shrink-0" style="width:1.75rem;height:1.75rem;max-width:1.75rem;display:block;">
                                                    <path d="M2.273 5.625A4.483 4.483 0 0 1 5.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0 0 18.75 3H5.25a3 3 0 0 0-2.977 2.625ZM2.273 8.625A4.483 4.483 0 0 1 5.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0 0 18.75 6H5.25a3 3 0 0 0-2.977 2.625ZM5.25 9a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3h13.5a3 3 0 0 0 3-3v-6a3 3 0 0 0-3-3H15v1.5a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 10.5V9H5.25Z" />
                                                </svg>
                                            @else
                                                <span class="inline-flex items-center justify-center h-7 w-7 rounded-full bg-gray-100 text-[10px] font-bold text-gray-700 shrink-0" style="width:1.75rem;height:1.75rem;max-width:1.75rem;line-height:1;">
                                                    {{ strtoupper(substr($nombreBanco, 0, 2)) }}
                                                </span>
                                            @endif
                                            <div class="min-w-0">
                                                <span class="block font-semibold text-gray-700 leading-tight">{{ $nombreBanco }}</span>
                                                <span class="block text-xs text-gray-400 leading-tight">{{ $cuenta->moneda }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    @foreach($dias as $dia)
                                        @php
                                            $key   = $dia->toDateString();
                                            $esHoy = $key === $hoy;
                                            $celda = $rows->get($key)?->get($cuenta->id);
                                        @endphp
                                        <td class="px-3 py-3 text-right {{ $esHoy ? 'bg-indigo-50' : '' }}">
                                            @if($celda && $celda->total > 0)
                                                @php
                                                    $vsDetalle   = $detalles->get($key)?->get($cuenta->id) ?? collect();
                                                    $totalPagado = (float) $celda->total_pagado;
                                                    $totalPend   = $celda->total - $totalPagado;
                                                    $todoPagado  = $totalPagado >= $celda->total;
                                                @endphp
                                                <div class="inline-block cursor-default"
                                                     onmouseenter="ttShow(this)"
                                                     onmouseleave="ttHide(this)"
                                                     onmousemove="ttMove(this, event)">
                                                    @if($todoPagado)
                                                        <span class="font-semibold text-green-600 line-through decoration-green-400">
                                                            {{ number_format($celda->total, 2, ',', '.') }}
                                                        </span>
                                                        <span class="ml-0.5 text-green-500 text-xs">✓</span>
                                                    @elseif($totalPagado > 0)
                                                        <span class="font-semibold {{ $esHoy ? 'text-indigo-700' : 'text-gray-800' }} underline decoration-dotted {{ $esHoy ? 'decoration-indigo-400' : 'decoration-gray-300' }}">
                                                            {{ number_format($totalPend, 2, ',', '.') }}
                                                        </span>
                                                        <span class="ml-0.5 text-green-500 text-xs" title="Pago: {{ number_format($totalPagado, 2, ',', '.') }}">✓p</span>
                                                    @else
                                                        <span class="font-semibold {{ $esHoy ? 'text-indigo-700' : 'text-gray-800' }} underline decoration-dotted {{ $esHoy ? 'decoration-indigo-400' : 'decoration-gray-300' }}">
                                                            {{ number_format($celda->total, 2, ',', '.') }}
                                                        </span>
                                                    @endif
                                                    <div data-tt style="display:none; position:fixed; z-index:9999;"
                                                         class="bg-white border border-indigo-300 border-l-[3px] border-l-indigo-500 rounded-lg shadow-xl p-3 text-sm pointer-events-none" style="min-width:200px">
                                                        @foreach($vsDetalle as $v)
                                                            <div class="flex justify-between items-start gap-2 py-0.5 {{ !$loop->last ? 'border-b border-gray-100' : '' }} {{ $v->fecha_pago ? 'opacity-60' : '' }}">
                                                                <span class="{{ $v->fecha_pago ? 'text-green-700 line-through' : 'text-gray-800' }}">
                                                                    @if($v->fecha_pago)<span class="text-green-500 mr-0.5">✓</span>@endif
                                                                    {{ $v->rubro?->nombre ?? '—' }}@if($v->comentario) <em class="text-gray-500"> · {{ $v->comentario }}</em>@endif
                                                                </span>
                                                                <span class="font-semibold {{ $v->fecha_pago ? 'text-green-600' : 'text-gray-900' }} whitespace-nowrap">{{ number_format($v->importe, 2, ',', '.') }}</span>
                                                            </div>
                                                        @endforeach
                                                        @if($vsDetalle->count() > 1)
                                                            <div class="flex justify-between items-center border-t border-gray-300 mt-1 pt-1 font-bold text-gray-900">
                                                                <span>Total</span>
                                                                <span>{{ number_format($celda->total, 2, ',', '.') }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-gray-200">—</span>
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="px-4 py-3 text-right font-bold text-gray-800">
                                        @if($totalesPorCuenta[$cuenta->id] > 0)
                                            @php $vsTotal = $dias->flatMap(fn($d) => $detalles->get($d->toDateString())?->get($cuenta->id) ?? collect())->sortByDesc('importe')->values(); @endphp
                                            <div class="inline-block cursor-default"
                                                 onmouseenter="ttShow(this)"
                                                 onmouseleave="ttHide(this)"
                                                 onmousemove="ttMove(this, event)">
                                                <span class="underline decoration-dotted decoration-gray-300">
                                                    {{ number_format($totalesPorCuenta[$cuenta->id], 2, ',', '.') }}
                                                </span>
                                                <div data-tt style="display:none; position:fixed; z-index:9999; min-width:220px"
                                                     class="bg-white border border-indigo-300 border-l-[3px] border-l-indigo-500 rounded-lg shadow-xl p-3 text-sm pointer-events-none">
                                                    @foreach($vsTotal as $v)
                                                        <div class="flex justify-between items-start gap-2 py-0.5 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                                            <span class="text-gray-500 whitespace-nowrap" style="font-size:11px">{{ \Carbon\Carbon::parse($v->fecha)->format('d/m') }}</span>
                                                            <span class="text-gray-800 flex-1 px-1">{{ $v->rubro?->nombre ?? '—' }}@if($v->comentario) <em class="text-gray-500"> · {{ $v->comentario }}</em>@endif</span>
                                                            <span class="font-semibold text-gray-900 whitespace-nowrap">{{ number_format($v->importe, 2, ',', '.') }}</span>
                                                        </div>
                                                    @endforeach
                                                    @if($vsTotal->count() > 1)
                                                        <div class="flex justify-between items-center border-t border-gray-300 mt-1 pt-1 font-bold text-gray-900">
                                                            <span>Total</span>
                                                            <span>{{ number_format($totalesPorCuenta[$cuenta->id], 2, ',', '.') }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-gray-300">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            {{-- Subtotal del grupo --}}
                            <tr class="bg-gray-50 border-t border-gray-300">
                                <td class="px-4 py-2 text-xs font-bold text-gray-500 uppercase">
                                    Subtotal {{ $moneda }}
                                </td>
                                @foreach($dias as $dia)
                                    @php
                                        $key   = $dia->toDateString();
                                        $esHoy = $key === $hoy;
                                        $sub   = $subtotalesPorDia[$moneda][$key] ?? 0;
                                    @endphp
                                    <td class="px-3 py-2 text-right {{ $esHoy ? 'bg-indigo-50' : '' }}">
                                        @if($sub > 0)
                                            @php $vsSubDia = $cuentasGrupo->flatMap(fn($c) => $detalles->get($key)?->get($c->id) ?? collect())->sortByDesc('importe')->values(); @endphp
                                            <div class="inline-block cursor-default"
                                                 onmouseenter="ttShow(this)"
                                                 onmouseleave="ttHide(this)"
                                                 onmousemove="ttMove(this, event)">
                                                <span class="font-bold {{ $esHoy ? 'text-indigo-700' : 'text-gray-700' }} underline decoration-dotted {{ $esHoy ? 'decoration-indigo-400' : 'decoration-gray-300' }}">
                                                    {{ number_format($sub, 2, ',', '.') }}
                                                </span>
                                                <div data-tt style="display:none; position:fixed; z-index:9999; min-width:200px"
                                                     class="bg-white border border-indigo-300 border-l-[3px] border-l-indigo-500 rounded-lg shadow-xl p-3 text-sm pointer-events-none">
                                                    @foreach($vsSubDia as $v)
                                                        <div class="flex justify-between items-start gap-2 py-0.5 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                                            <span class="text-gray-800">{{ $v->rubro?->nombre ?? '—' }}@if($v->comentario) <em class="text-gray-500"> · {{ $v->comentario }}</em>@endif</span>
                                                            <span class="font-semibold text-gray-900 whitespace-nowrap">{{ number_format($v->importe, 2, ',', '.') }}</span>
                                                        </div>
                                                    @endforeach
                                                    @if($vsSubDia->count() > 1)
                                                        <div class="flex justify-between items-center border-t border-gray-300 mt-1 pt-1 font-bold text-gray-900">
                                                            <span>Total</span>
                                                            <span>{{ number_format($sub, 2, ',', '.') }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-gray-200">—</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="px-4 py-2 text-right font-extrabold text-gray-900">
                                    @if($subtotalesSemana[$moneda] > 0)
                                        @php $vsSubSemana = $dias->flatMap(fn($d) => $cuentasGrupo->flatMap(fn($c) => $detalles->get($d->toDateString())?->get($c->id) ?? collect()))->sortByDesc('importe')->values(); @endphp
                                        <div class="inline-block cursor-default"
                                             onmouseenter="ttShow(this)"
                                             onmouseleave="ttHide(this)"
                                             onmousemove="ttMove(this, event)">
                                            <span class="underline decoration-dotted decoration-gray-400">
                                                {{ $moneda }} {{ number_format($subtotalesSemana[$moneda], 2, ',', '.') }}
                                            </span>
                                            <div data-tt style="display:none; position:fixed; z-index:9999; min-width:220px"
                                                 class="bg-white border border-indigo-300 border-l-[3px] border-l-indigo-500 rounded-lg shadow-xl p-3 text-sm pointer-events-none">
                                                @foreach($vsSubSemana as $v)
                                                    <div class="flex justify-between items-start gap-2 py-0.5 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                                        <span class="text-gray-500 whitespace-nowrap" style="font-size:11px">{{ \Carbon\Carbon::parse($v->fecha)->format('d/m') }}</span>
                                                        <span class="text-gray-800 flex-1 px-1">{{ $v->rubro?->nombre ?? '—' }}@if($v->comentario) <em class="text-gray-500"> · {{ $v->comentario }}</em>@endif</span>
                                                        <span class="font-semibold text-gray-900 whitespace-nowrap">{{ number_format($v->importe, 2, ',', '.') }}</span>
                                                    </div>
                                                @endforeach
                                                @if($vsSubSemana->count() > 1)
                                                    <div class="flex justify-between items-center border-t border-gray-300 mt-1 pt-1 font-bold text-gray-900">
                                                        <span>Total</span>
                                                        <span>{{ $moneda }} {{ number_format($subtotalesSemana[$moneda], 2, ',', '.') }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-300">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <p class="mt-3 text-xs text-gray-400 italic">
            Muestra vencimientos, préstamos y cheques, con cuenta asignada o agrupados en “Sin estimar”, incluyendo los ya pagados.
        </p>
    @endif
</div>

@push('scripts')
<script>
if (typeof window.ttShow !== 'function') {
    window.ttShow = function(el) {
        var t = el.querySelector('[data-tt]');
        if (t) t.style.display = 'block';
    }
}

if (typeof window.ttHide !== 'function') {
    window.ttHide = function(el) {
        var t = el.querySelector('[data-tt]');
        if (t) t.style.display = 'none';
    }
}

if (typeof window.ttMove !== 'function') {
    window.ttMove = function(el, e) {
        var t = el.querySelector('[data-tt]');
        if (!t || t.style.display === 'none') return;
        var x = e.clientX + 16;
        var y = e.clientY - 10;
        if (x + t.offsetWidth > window.innerWidth - 10) {
            x = e.clientX - t.offsetWidth - 10;
        }
        t.style.left = x + 'px';
        t.style.top  = y + 'px';
    }
}
</script>
@endpush
