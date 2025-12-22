<div wire:init="loadRegistros">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
 
        <div class="p-4 w-full  text-gray-900 border-b border-gray-200 dark:text-gray-100
            md:flex md:justify-between md:items-center">

            <div class="px-2 py-2 w-full flex items-center">
                <div class="flex items-center">
                    <span>Mostrar</span>
                    <select wire:model="cantidad" class="mx-2 font-medium text-sm text-gray-700 dark:text-gray-300 
                    border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" >
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>registros</span>
                </div>
                <x-text-input id="search" class="block flex-1 mx-4" type="text" wire:model="search" 
                    placeholder="Ingrese el texto a buscar" />    
            </div>
        </div>

        @if (count($rubros))
            <!-- Table -->
            <table class='mx-auto max-w-6xl w-full whitespace-nowrap rounded-lg bg-white divide-y divide-gray-300 overflow-hidden'>
                <thead class="bg-gray-150">
                    <tr class="text-gray-600 text-left bg-gray-150">
                        <th class="cursor-pointer text-gray-900 font-semibold text-sm uppercase px-6 py-4"
                            wire:click="order('nombre')">
                            Concepto
                            {{-- sort --}}
                            @if ($sort == 'nombre')
                                @if ($direction == 'asc')
                                    <i class="fa-solid fa-arrow-up-wide-short float-right mt-1"></i> 
                                @else
                                    <i class="fa-solid fa-arrow-down-wide-short float-right mt-1"></i> 
                                @endif
                            @else
                                <i class="fa-solid fa-sort float-right mt-1"></i> 
                            @endif
                        </th>
                        <th class="cursor-pointer text-center text-gray-900 font-semibold text-sm uppercase px-6 py-4"
                        wire:click="order('moneda')">
                            Moneda
                            {{-- sort --}}
                            @if ($sort == 'moneda')
                                @if ($direction == 'asc')
                                    <i class="fa-solid fa-arrow-up-wide-short float-right mt-1"></i> 
                                @else
                                    <i class="fa-solid fa-arrow-down-wide-short float-right mt-1"></i> 
                                @endif
                            @else
                                <i class="fa-solid fa-sort float-right mt-1"></i> 
                            @endif
                        </th>
                        <th class="cursor-pointer text-gray-900 font-semibold text-sm uppercase px-6 py-4"
                        wire:click="order('banco_id')">
                            Banco
                            {{-- sort --}}           
                            @if ($sort == 'banco_id')
                                @if ($direction == 'asc')
                                    <i class="fa-solid fa-arrow-up-wide-short float-right mt-1"></i> 
                                @else
                                    <i class="fa-solid fa-arrow-down-wide-short float-right mt-1"></i> 
                                @endif
                            @else
                                <i class="fa-solid fa-sort float-right mt-1"></i> 
                            @endif         
                        </th>                        

                        <th class="cursor-pointer text-gray-900 font-semibold text-sm uppercase px-6 py-4"
                        wire:click="order('color')">
                            Forma de pago
                            {{-- sort --}}
                            @if ($sort == 'color')
                                @if ($direction == 'asc')
                                    <i class="fa-solid fa-arrow-up-wide-short float-right mt-1"></i> 
                                @else
                                    <i class="fa-solid fa-arrow-down-wide-short float-right mt-1"></i> 
                                @endif
                            @else
                                <i class="fa-solid fa-sort float-right mt-1"></i> 
                            @endif
                        </th>
                        <th class="font-semibold text-sm uppercase px-6 py-4">
                            
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($rubros as $rubro)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-800">
                                    {{ $rubro->nombre }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm text-gray-800">
                                    {{ $rubro->moneda }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="text-sm text-gray-800">
                                    {{ $rubro->muestroNombreBanco()}}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-800">
                                    @if ($rubro->color == 1)
                                        <h2 class="text-l">{{ $rubro->mostrarColor() }}</h2>
                                    @elseif ($rubro->color == 2)
                                        <h2 class="text-l text-red-700">{{ $rubro->mostrarColor() }}</h2>
                                    @else 
                                        <h2 class="text-l text-blue-700">{{ $rubro->mostrarColor() }}</h2>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 text-right">
                                <button onclick="window.location.href='{{ route('rubros.edit', $rubro->id) }}'" 
                                    class="bg-gray-800 py-2 px-3 text-center rounded-lg text-white text-xs font-bold uppercase">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-4">
                                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                        <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                      </svg>
                                </button>
            
                                <button
                                    wire:click="$emit('prueba', {{ $rubro->id }})" 
                                    class="bg-red-600 py-2 px-2 text-center rounded-lg text-white text-xs font-bold uppercase">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-4">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                      </svg>                          
                                </button>    
                                           
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

            <div class="mt-5">
                {{ $rubros->links() }}
            </div>
        @else
            @if ($readyToLoad)
                <div class="px-8 py-4">No hay conceptos a mostrar</div>
            @else
                <div class="flex justify-center h-14">
                    <img src="{{ asset('progress.gif')}}" alt="Cargando">
                </div>
            @endif          
        </div>

        @endif
    
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        Livewire.on('prueba', rubroId => {
            Swal.fire({
                title: "¿Eliminar el rubro?",
                text: "Un rubro eliminado no se puede recuperar y puede alterar los recibos ya emitidos",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1F2937",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar rubro!",
                cancelButtonText: 'Cancelar'
                }).then((result) => {
            if (result.isConfirmed) {
                // eliminarl del  servidor
                Livewire.emit('eliminarRubro', rubroId)
                Swal.fire({
                    title: "Se elimino el rubro",
                    text: "Eliminado correctamente.",
                    icon: "success",
                    confirmButtonColor: "#166534"
                });
            }
            });
        })
    </script>

@endpush