<div wire:init="loadRegistros">
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

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-4 w-full text-gray-900 border-b border-gray-200 dark:text-gray-100">
            <div class="px-2 pb-3 w-full">
                <div class="flex flex-col xl:flex-row xl:items-end xl:justify-between gap-4">
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-500 mb-2">Filtrar por banco</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($bancos as $banco)
                                @php
                                    $bId = $banco->id;
                                    $bNombre = $banco->nombre;
                                    $icono = $iconos[$bNombre] ?? null;
                                    $activo = (string)$bancoFiltro === (string)$bId;
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
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="h-9 w-9 mb-1 {{ $activo ? 'text-indigo-600' : 'text-gray-500' }}" style="width:2.25rem;height:2.25rem;max-width:2.25rem;display:block;">
                                            <path d="M2.273 5.625A4.483 4.483 0 0 1 5.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0 0 18.75 3H5.25a3 3 0 0 0-2.977 2.625ZM2.273 8.625A4.483 4.483 0 0 1 5.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0 0 18.75 6H5.25a3 3 0 0 0-2.977 2.625ZM5.25 9a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3h13.5a3 3 0 0 0 3-3v-6a3 3 0 0 0-3-3H15v1.5a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 10.5V9H5.25Z" />
                                        </svg>
                                    @else
                                        <span class="text-lg font-extrabold {{ $activo ? 'text-indigo-600' : 'text-gray-500' }}">
                                            {{ strtoupper(substr($bNombre, 0, 2)) }}
                                        </span>
                                    @endif
                                    <span class="text-[10px] font-semibold leading-tight {{ $activo ? 'text-indigo-700' : 'text-gray-500' }}">
                                        {{ $bNombre }}
                                    </span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="xl:pb-1">
                        <label class="block text-xs font-medium text-gray-500 mb-2">Moneda</label>
                        <div class="flex flex-wrap items-center gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="monedaFiltro" value=""
                                    class="text-indigo-600 border-gray-300 focus:ring-indigo-500 w-4 h-4">
                                <span class="text-sm font-semibold {{ $monedaFiltro === '' ? 'text-indigo-700' : 'text-gray-500' }}">Todas</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="monedaFiltro" value="$"
                                    class="text-indigo-600 border-gray-300 focus:ring-indigo-500 w-4 h-4">
                                <span class="text-sm font-semibold {{ $monedaFiltro === '$' ? 'text-indigo-700' : 'text-gray-500' }}">$ Pesos</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="monedaFiltro" value="U$S"
                                    class="text-indigo-600 border-gray-300 focus:ring-indigo-500 w-4 h-4">
                                <span class="text-sm font-semibold {{ $monedaFiltro === 'U$S' ? 'text-indigo-700' : 'text-gray-500' }}">U$S Dólares</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" wire:model="monedaFiltro" value="UI"
                                    class="text-indigo-600 border-gray-300 focus:ring-indigo-500 w-4 h-4">
                                <span class="text-sm font-semibold {{ $monedaFiltro === 'UI' ? 'text-indigo-700' : 'text-gray-500' }}">UI</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-2 pt-3 w-full flex flex-wrap items-center gap-3 border-t border-gray-100">
                <div class="flex items-center">
                    <span>Mostrar</span>
                    <select wire:model="cantidad" class="mx-2 font-medium text-sm text-gray-700 dark:text-gray-300 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>registros</span>
                </div>
                <x-text-input id="search" class="block flex-1 min-w-[180px]" type="text" wire:model="search" placeholder="Buscar por cuenta, moneda, cuota, importe o comentario" />

                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-600 whitespace-nowrap">Desde</span>
                    <input type="date" wire:model="vencimientoDesde" class="text-sm text-gray-700 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <span class="text-sm text-gray-600 whitespace-nowrap">Hasta</span>
                    <input type="date" wire:model="vencimientoHasta" class="text-sm text-gray-700 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                </div>

                @if($search || $bancoFiltro || $monedaFiltro || $vencimientoDesde || $vencimientoHasta)
                    <button wire:click="limpiarFiltros" class="text-xs text-gray-400 hover:text-red-500 transition" title="Limpiar filtros">
                        ✕ Limpiar
                    </button>
                @endif
            </div>
        </div>

        @if (count($prestamos))
            <table class="mx-auto max-w-6xl w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden">
                <thead class="bg-gray-150">
                    <tr class="text-gray-600 text-left bg-gray-150">
                        <th class="cursor-pointer text-gray-900 font-semibold text-sm uppercase px-6 py-4" wire:click="order('cuenta_id')">Cuenta</th>
                        <th class="cursor-pointer text-center text-gray-900 font-semibold text-sm uppercase px-6 py-4" wire:click="order('moneda')">Moneda</th>
                        <th class="cursor-pointer text-center text-gray-900 font-semibold text-sm uppercase px-6 py-4" wire:click="order('cuota')">Cuota</th>
                        <th class="cursor-pointer text-right text-gray-900 font-semibold text-sm uppercase px-6 py-4" wire:click="order('importe')">Importe</th>
                        <th class="cursor-pointer text-center text-gray-900 font-semibold text-sm uppercase px-6 py-4" wire:click="order('vencimiento')">Vencimiento</th>
                        <th class="text-gray-900 font-semibold text-sm uppercase px-6 py-4">Comentario</th>
                        <th class="font-semibold text-sm uppercase px-6 py-4"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($prestamos as $prestamo)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                {{ $prestamo->cuenta?->banco?->nombre ?? 'Sin banco' }} {{ $prestamo->cuenta?->moneda ?? '' }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-800">{{ $prestamo->moneda }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-800">{{ $prestamo->cuota }}</td>
                            <td class="px-6 py-4 text-right text-sm text-gray-800">{{ number_format($prestamo->importe, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-800">{{ \Carbon\Carbon::parse($prestamo->vencimiento)->format('d-m-Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $prestamo->comentario ?: '—' }}</td>
                            <td class="py-4 text-right">
                                <button onclick="window.location.href='{{ route('prestamos.edit', $prestamo->id) }}'" class="bg-gray-800 py-2 px-3 text-center rounded-lg text-white text-xs font-bold uppercase mr-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-4">
                                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                        <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                      </svg>
                                </button>

                                <button wire:click="$emit('confirmarEliminarPrestamo', {{ $prestamo->id }})" class="bg-red-600 py-2 px-2 text-center rounded-lg text-white text-xs font-bold uppercase">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-4">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-5">
                {{ $prestamos->links() }}
            </div>
        @else
            @if ($readyToLoad)
                <div class="px-8 py-4">No hay préstamos para mostrar</div>
            @else
                <div class="flex justify-center h-14">
                    <img src="{{ asset('progress.gif')}}" alt="Cargando">
                </div>
            @endif
        @endif
    </div>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Livewire.on('confirmarEliminarPrestamo', prestamoId => {
            Swal.fire({
                title: '¿Eliminar el préstamo?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1F2937',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar préstamo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('eliminarPrestamo', prestamoId)
                    Swal.fire({
                        title: 'Préstamo eliminado',
                        text: 'Eliminado correctamente.',
                        icon: 'success',
                        confirmButtonColor: '#166534'
                    });
                }
            });
        })
    </script>
@endpush
