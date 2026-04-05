<div wire:init="loadData">
    {{-- Selector de cuenta y filtros --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5 mb-5">
        <div class="flex flex-col gap-4">

            {{-- Fila 1: Iconos de banco --}}
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-2">Seleccionar banco</label>
                <div class="flex flex-wrap gap-2">
                    @php
                        $iconos = [
                            'HSBC' => 'hsbc.png',
                            'Scotiabank' => 'scotiabank.png',
                            'Santander' => 'santander.png',
                            'BROU' => 'brou.png',
                            'BBVA' => 'bbva.png',
                            'Itaú' => 'itau.png',
                            'Caja' => null,
                        ];
                    @endphp
                    @foreach($bancos as $banco)
                        @php
                            $bId = is_object($banco) ? $banco->id : $banco['id'];
                            $bNombre = is_object($banco) ? $banco->nombre : $banco['nombre'];
                            $icono = $iconos[$bNombre] ?? null;
                            $activo = $bancoId == $bId;
                        @endphp
                        <button wire:click="seleccionarBanco({{ $bId }})"
                            class="flex flex-col items-center justify-center w-20 h-20 rounded-xl border-2 transition
                                {{ $activo
                                    ? 'border-indigo-500 bg-indigo-50 shadow-md ring-2 ring-indigo-200'
                                    : 'border-gray-200 bg-white hover:border-gray-400 hover:bg-gray-50' }}"
                            style="width:5rem;height:5rem;border-width:2px;border-style:solid;border-color:{{ $activo ? '#6366f1' : '#e5e7eb' }};background-color:{{ $activo ? '#eef2ff' : '#ffffff' }};">
                            @if($icono)
                                <img src="{{ asset($icono) }}" alt="{{ $bNombre }}" class="h-9 w-9 object-contain mb-1" style="width:2.25rem;height:2.25rem;max-width:2.25rem;object-fit:contain;display:block;">
                            @elseif($bNombre === 'Caja')
                                {{-- Icono caja chica SVG --}}
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="h-9 w-9 mb-1 {{ $activo ? 'text-indigo-600' : 'text-gray-500' }}" style="width:2.25rem;height:2.25rem;max-width:2.25rem;display:block;">
                                    <path d="M2.273 5.625A4.483 4.483 0 0 1 5.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0 0 18.75 3H5.25a3 3 0 0 0-2.977 2.625ZM2.273 8.625A4.483 4.483 0 0 1 5.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0 0 18.75 6H5.25a3 3 0 0 0-2.977 2.625ZM5.25 9a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3h13.5a3 3 0 0 0 3-3v-6a3 3 0 0 0-3-3H15v1.5a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 10.5V9H5.25Z" />
                                </svg>
                            @else
                                {{-- Fallback: iniciales --}}
                                <span class="text-lg font-extrabold {{ $activo ? 'text-indigo-600' : 'text-gray-500' }}">
                                    {{ $bNombre }}
                                </span>
                            @endif
                            <span class="text-[10px] font-semibold leading-tight {{ $activo ? 'text-indigo-700' : 'text-gray-500' }}">
                                {{ $bNombre }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Fila 2: Moneda + Saldo --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model="monedaSeleccionada" value="$"
                            class="text-indigo-600 border-gray-300 focus:ring-indigo-500 w-4 h-4">
                        <span class="text-sm font-semibold {{ $monedaSeleccionada === '$' ? 'text-indigo-700' : 'text-gray-500' }}">$ Pesos</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model="monedaSeleccionada" value="U$S"
                            class="text-indigo-600 border-gray-300 focus:ring-indigo-500 w-4 h-4">
                        <span class="text-sm font-semibold {{ $monedaSeleccionada === 'U$S' ? 'text-indigo-700' : 'text-gray-500' }}">U$S Dólares</span>
                    </label>
                </div>
                @if($cuenta)
                <div class="text-right">
                    <p class="text-xs text-gray-500">Saldo actual</p>
                    <p class="text-2xl font-extrabold {{ $saldoActual >= 0 ? 'text-green-700' : 'text-red-700' }}">
                        {{ $cuenta->moneda }} {{ number_format($saldoActual, 2, ',', '.') }}
                    </p>
                </div>
                @endif
            </div>

            {{-- Fila 3: Rango de fechas --}}
            <div class="flex flex-col sm:flex-row sm:items-end gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Desde</label>
                    <input type="date" wire:model.lazy="fechaDesde"
                        class="block w-full sm:w-44 border-gray-300 rounded-md shadow-sm focus:border-indigo-400 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Hasta</label>
                    <input type="date" wire:model.lazy="fechaHasta"
                        class="block w-full sm:w-44 border-gray-300 rounded-md shadow-sm focus:border-indigo-400 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                </div>
                <div wire:loading class="flex items-center gap-2 text-indigo-600 text-sm pb-1">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Actualizando...
                </div>
            </div>

        </div>
    </div>

    @if($cuenta)

    @if(!$readyToLoad)
    {{-- Loading inicial --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-10 flex flex-col items-center justify-center gap-3">
        <svg class="animate-spin h-8 w-8 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
        </svg>
        <p class="text-sm text-gray-500">Cargando estado de cuenta...</p>
    </div>
    @else

    {{-- Botón agregar movimiento --}}
    <div class="mb-4 flex justify-end">
        <button wire:click="abrirModal"
            class="bg-green-700 hover:bg-green-800 py-2 px-4 rounded-lg text-white text-sm font-bold uppercase transition">
            + Agregar movimiento
        </button>
    </div>

    {{-- Resumen diario --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden mb-4">
        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wide text-gray-700">Resumen {{ $agrupacion === 'mes' ? 'mensual' : 'diario' }}</h3>
                    <p class="text-xs text-gray-500 mt-1">Saldo inicial, movimientos del período y saldo final para el rango seleccionado.</p>
                </div>

                <div class="inline-flex rounded-lg border border-gray-200 overflow-hidden self-start sm:self-auto">
                    <button wire:click="setAgrupacion('dia')"
                        class="px-3 py-1.5 text-xs font-semibold transition {{ $agrupacion === 'dia' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                        Día
                    </button>
                    <button wire:click="setAgrupacion('mes')"
                        class="px-3 py-1.5 text-xs font-semibold transition border-l border-gray-200 {{ $agrupacion === 'mes' ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                        Mes
                    </button>
                </div>
            </div>
        </div>

        <table class="w-full text-sm divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Fecha</th>
                    <th class="px-3 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Saldo inicial</th>
                    <th class="px-3 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Ingresos</th>
                    <th class="px-3 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Egresos</th>
                    <th class="px-3 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Saldo final</th>
                    <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Movs.</th>
                </tr>
            </thead>
            @forelse ($resumenDiario as $dia)
                <tbody x-data="{ open: false }" class="divide-y divide-gray-100" @mouseleave="open = false">
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }} hover:bg-gray-100 transition">
                        <td class="px-3 py-2 text-gray-700 whitespace-nowrap font-medium cursor-pointer"
                            @mouseenter="open = true">
                            {{ $dia->etiqueta }}
                        </td>
                        <td class="px-3 py-2 text-right text-gray-700 font-semibold">
                            {{ $cuenta->moneda }} {{ number_format($dia->saldo_inicial, 2, ',', '.') }}
                        </td>
                        <td class="px-3 py-2 text-right text-green-700 font-semibold">
                            {{ $cuenta->moneda }} {{ number_format($dia->ingresos, 2, ',', '.') }}
                        </td>
                        <td class="px-3 py-2 text-right text-red-700 font-semibold">
                            {{ $cuenta->moneda }} {{ number_format($dia->egresos, 2, ',', '.') }}
                        </td>
                        <td class="px-3 py-2 text-right font-bold {{ $dia->saldo_final >= 0 ? 'text-green-700' : 'text-red-700' }}">
                            {{ $cuenta->moneda }} {{ number_format($dia->saldo_final, 2, ',', '.') }}
                        </td>
                        <td class="px-3 py-2 text-center text-gray-500">
                            {{ $dia->cantidad_movimientos }}
                        </td>
                    </tr>

                    <tr x-show="open" x-transition>
                        <td colspan="6" class="px-4 py-3 bg-indigo-50/50 border-t border-indigo-100">
                            <div class="space-y-2">
                                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-700">
                                    Movimientos del {{ $agrupacion === 'mes' ? 'mes' : 'día' }}
                                </p>

                                @foreach ($dia->movimientos as $mov)
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 rounded-md bg-white border border-gray-200 px-3 py-2 text-xs">
                                        <div class="flex items-center gap-2 text-gray-700 min-w-0">
                                            <span class="font-semibold whitespace-nowrap">
                                                {{ $mov->fecha instanceof \Carbon\Carbon ? $mov->fecha->format('d/m/Y') : \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y') }}
                                            </span>
                                            <span class="truncate">{{ $mov->concepto }}</span>
                                            @if($mov->origen === 'vencimiento')
                                                <span class="inline-block px-1.5 py-0.5 text-[10px] font-semibold rounded bg-indigo-100 text-indigo-700">Vto</span>
                                            @elseif($mov->origen === 'cheque')
                                                <span class="inline-block px-1.5 py-0.5 text-[10px] font-semibold rounded bg-yellow-100 text-yellow-800">Cheque</span>
                                            @elseif($mov->origen === 'manual')
                                                <span class="inline-block px-1.5 py-0.5 text-[10px] font-semibold rounded bg-gray-100 text-gray-700">Manual</span>
                                            @endif
                                        </div>
                                        <div class="text-right font-semibold {{ $mov->tipo_mov === 'ingreso' ? 'text-green-700' : 'text-red-700' }} whitespace-nowrap">
                                            {{ $mov->tipo_mov === 'ingreso' ? '+' : '-' }} {{ $mov->moneda }} {{ number_format($mov->importe, 2, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                </tbody>
            @empty
                <tbody>
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                            No hay movimientos en el rango seleccionado.
                        </td>
                    </tr>
                </tbody>
            @endforelse
        </table>
    </div>

    {{-- Tabla extracto --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
        <table class="w-full text-sm divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase w-24">Fecha</th>
                    <th class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Concepto</th>
                    <th class="px-3 py-3 text-right text-xs font-semibold text-gray-500 uppercase w-32">Egreso</th>
                    <th class="px-3 py-3 text-right text-xs font-semibold text-gray-500 uppercase w-32">Ingreso</th>
                    <th class="px-3 py-3 text-center text-xs font-semibold text-gray-500 uppercase w-20"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($extracto as $mov)
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }} hover:bg-gray-100 transition">
                        <td class="px-3 py-2 text-gray-700 whitespace-nowrap text-sm">
                            {{ $mov->fecha instanceof \Carbon\Carbon ? $mov->fecha->format('d/m/Y') : \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y') }}
                        </td>
                        <td class="px-3 py-2 text-gray-800">
                            <span class="font-medium text-sm">{{ $mov->concepto }}</span>
                            @if($mov->origen === 'vencimiento')
                                <span class="ml-1 inline-block px-1.5 py-0.5 text-xs font-semibold rounded bg-indigo-100 text-indigo-700">Vto</span>
                            @elseif($mov->origen === 'cheque')
                                <span class="ml-1 inline-block px-1.5 py-0.5 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">Cheque</span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-right text-sm font-semibold {{ $mov->tipo_mov === 'egreso' ? 'text-red-700' : 'text-gray-300' }}">
                            @if($mov->tipo_mov === 'egreso')
                                {{ $mov->moneda }} {{ number_format($mov->importe, 2, ',', '.') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-3 py-2 text-right text-sm font-semibold {{ $mov->tipo_mov === 'ingreso' ? 'text-green-700' : 'text-gray-300' }}">
                            @if($mov->tipo_mov === 'ingreso')
                                {{ $mov->moneda }} {{ number_format($mov->importe, 2, ',', '.') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-2 py-2 text-center whitespace-nowrap">
                            @if($mov->origen === 'manual')
                                <button onclick="confirmarEdicion({{ $mov->id }})"
                                    class="bg-gray-800 hover:bg-gray-900 py-2 px-2 text-center rounded-lg text-white text-xs font-bold uppercase mr-1 transition"
                                    title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-4">
                                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                        <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                    </svg>
                                </button>
                                <button wire:click="eliminarMovimiento({{ $mov->id }})"
                                    class="bg-red-600 hover:bg-red-700 py-2 px-2 text-center rounded-lg text-white text-xs font-bold uppercase transition"
                                    title="Eliminar">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-4">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-400">
                            No hay movimientos registrados para esta cuenta.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal agregar movimiento --}}
    @if($modalAbierto)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">{{ $editandoId ? 'Editar movimiento' : 'Nuevo movimiento' }}</h3>

            {{-- Tipo: Ingreso / Egreso --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model="tipo_mov" value="egreso"
                            class="text-red-600 border-gray-300 focus:ring-red-500">
                        <span class="text-sm font-medium text-red-700">Egreso (salida)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model="tipo_mov" value="ingreso"
                            class="text-green-600 border-gray-300 focus:ring-green-500">
                        <span class="text-sm font-medium text-green-700">Ingreso (entrada)</span>
                    </label>
                </div>
            </div>

            {{-- Fecha --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                <input type="date" wire:model="fecha"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                @error('fecha')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Concepto predefinido --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Concepto</label>
                <select wire:model="conceptoSeleccionado"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm mb-2">
                    <option value="">-- Seleccionar --</option>
                    @foreach($conceptosPredefinidos as $cp)
                        <option value="{{ $cp }}">{{ $cp }}</option>
                    @endforeach
                </select>
                @if($conceptoSeleccionado === 'Otro' || $conceptoSeleccionado === '')
                <input type="text" wire:model="concepto"
                    placeholder="Escribir concepto..."
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                @endif
                @error('concepto')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Importe --}}
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Importe ({{ $cuenta->moneda }})
                </label>
                <input type="number" step="0.01" wire:model="importe"
                    placeholder="0.00"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm">
                @error('importe')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-3">
                <button wire:click="cerrarModal"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 transition">
                    Cancelar
                </button>
                <button wire:click="guardarMovimiento"
                    class="px-4 py-2 rounded-lg text-sm font-bold text-white bg-green-700 hover:bg-green-800 transition">
                    Guardar
                </button>
            </div>
        </div>
    </div>
    @endif
    @endif {{-- fin @if readyToLoad --}}
    @endif {{-- fin @if($cuenta) --}}
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmarEdicion(id) {
        Swal.fire({
            title: '¿Editar este movimiento?',
            text: 'Estás modificando información anterior. Esto puede afectar los saldos de la cuenta.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4F46E5',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Sí, editar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('confirmarEdicionMovimiento', id);
            }
        });
    }

    document.addEventListener('livewire:load', () => {
        window.addEventListener('alerta-exitosa', event => {
            Swal.fire({
                title: event.detail.titulo,
                text: event.detail.mensaje,
                icon: event.detail.icono,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    });
</script>
@endpush
