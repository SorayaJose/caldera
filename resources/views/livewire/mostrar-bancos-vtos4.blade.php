<div wire:init="loadRegistros" >
    @php use Illuminate\Support\Str; @endphp
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
    <div class="grid grid-cols-3 gap-4 items-start" id='cuentas'>
        <!-- Muestro las cuentas y sus saldos -->
        <div class="col-span-2 bg-white p-4 rounded-lg shadow">            
            <div class="grid grid-cols-3 gap-4">
                @foreach ($bancos as $banco)   
                   
                    <div class="flex w-full max-w-sm overflow-hidden bg-gray-50 rounded-md shadow-md outline outline-black/5  dark:bg-gray-800">
                        <div class="w-full space-y-2 text-center ">
                            <div class="flex items-center justify-center bg-{{$banco->color()}}-500">
                                @if ($banco->color() == 'green')
                                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                                    </svg>   
                                    
                                @elseif ($banco->color() == 'red')
                                    <svg  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                
                                @else
                                    &nbsp;
                                @endif
                            </div>                    
                            <div class="w-full text-center border-b border-gray-200">
                                @php
                                    $iconoBanco = $iconosBanco[$banco->nombre] ?? null;
                                @endphp
                                @if($iconoBanco)
                                    <img src="{{ asset($iconoBanco) }}" alt="{{ $banco->nombre }}" class="mx-auto h-9 w-9 object-contain mt-2 mb-1" style="width:2.25rem;height:2.25rem;max-width:2.25rem;object-fit:contain;display:block;" />
                                @elseif($banco->nombre === 'Caja')
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="mx-auto h-9 w-9 text-gray-700 mt-2 mb-1" style="width:2.25rem;height:2.25rem;max-width:2.25rem;display:block;">
                                        <path d="M2.273 5.625A4.483 4.483 0 0 1 5.25 4.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0 0 18.75 3H5.25a3 3 0 0 0-2.977 2.625ZM2.273 8.625A4.483 4.483 0 0 1 5.25 7.5h13.5c1.141 0 2.183.425 2.977 1.125A3 3 0 0 0 18.75 6H5.25a3 3 0 0 0-2.977 2.625ZM5.25 9a3 3 0 0 0-3 3v6a3 3 0 0 0 3 3h13.5a3 3 0 0 0 3-3v-6a3 3 0 0 0-3-3H15v1.5a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 10.5V9H5.25Z" />
                                    </svg>
                                @else
                                    <span class="inline-flex items-center justify-center h-9 w-9 rounded-full bg-gray-100 text-xs font-bold text-gray-700 mx-auto mt-2 mb-1">
                                        {{ strtoupper(substr($banco->nombre, 0, 2)) }}
                                    </span>
                                @endif
                                <span class="block text-[10px] font-semibold leading-tight text-gray-600 mb-2">
                                    {{ $banco->nombre }}
                                </span>
                            </div>
                            <div class="flex gap-2 border-b border-gray-200">
                                
                                @if (count($banco->cuentas))
                                    @foreach ($banco->cuentas as $cuenta)
                                        <div class="drop-zone w-1/2" data-banco-id="{{$cuenta->id}}">
                                            <p class="text-{{$cuenta->color()}}-800 pb-1 pt-2">{{ $cuenta->moneda }}</p>
                                            <p class="text-{{$cuenta->color()}}-800 pb-5 pt-3 text-m font-bold">{{ number_format(($cuenta->saldo + $cuenta->saldo_tmp), 2, ',', '.') }}</p>
                                        </div>                                       
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Muestro como si fuera un banco el movimiento de efectivo -->
                <div class="col-span-2">
                    <div class="grid grid-row5 p-2 bg-gray-50 rounded-md  border border-gray-300  shadow-md outline outline-black/5  dark:bg-gray-800">
                        <div class=""><p class="text-m">Mover:</p></div>
                        <div>
                            <select wire:model="origen" name="origen" id="origen"
                            class="block mt-1 w-full font-medium text-gray-700 dark:text-gray-300 
                            border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <!-- <option  value="0" selected>Efectivo</option> -->
                                <!-- <option  value="99" selected>Cheque</option> -->
                            <option value="">-- Seleccionar origen --</option>
                            @foreach ($cuentas as $cuenta)
                                <option  value="{{$cuenta->id}}">{{$cuenta->banco->nombre}} en {{$cuenta->moneda}}</option>
                            @endforeach               
                        </select>
                        </div>
                        <div class="pt-2 pb-2">
                            <select wire:model="destino" name="destino" id="destino"
                            class="block mt-1 w-full font-medium text-gray-700 dark:text-gray-300 
                            border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                               <!-- <option  value="0" selected>Efectivo</option> -->
                               <!-- <option  value="99" selected>Cheque</option> -->
                               <option value="">-- Seleccionar destino --</option>
                            @foreach ($cuentas as $cuenta)
                               <option  value="{{$cuenta->id}}">{{$cuenta->banco->nombre}} en {{$cuenta->moneda}}</option>
                           @endforeach                   
                        </select>
                        </div>
                        <div class="pb-3" >
                            <div class="flex">
                                <div class="w-1/3 text-right pr-2">
                                    <select id="moneda" wire:model="moneda"
                                    class="w-full mt-1 pb-2 font-medium text-sm text-gray-700 dark:text-gray-300 
                                    border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="$">$</option>                    
                                    <option value="U$S">U$S</option>
                                    </select>
                                </div>
                                <div  class="w-2/3 text-left">
                                    <x-text-input id="importe" class="mt-1 w-full" type="text"
                                    wire:model="importe" placeholder="Importe" />
                                </div>
                            </div>            
                        </div>
                        <div class="pb-3">
                            <div class="flex items-center gap-4">
                                <label class="flex items-center gap-1 cursor-pointer text-sm text-gray-700">
                                    <input type="radio" wire:model="medioPago" value="cheque"
                                           class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                    Cheque
                                </label>
                                <label class="flex items-center gap-1 cursor-pointer text-sm text-gray-700">
                                    <input type="radio" wire:model="medioPago" value="transferencia"
                                           class="text-indigo-600 border-gray-300 focus:ring-indigo-500">
                                    Transferencia
                                </label>
                            </div>
                        </div>
                        <div class="pb-3">
                            <x-text-input id="comentarioMovimiento" class="mt-1 w-full" type="text"
                                wire:model.defer="comentarioMovimiento" placeholder="Comentario del movimiento (opcional)" />
                        </div>
                        <div class="">
                            <button
                            wire:click="movimiento" 
                                class="w-full pt-2 pb-2 h-full bg-gray-600 text-center rounded-lg text-white text-xs font-bold uppercase">
                                Planificar movimiento                          
                            </button>  
                        </div>
                    </div>
                </div>
            </div>
            <div class=" bg-white p-4 mt-3 rounded-lg border border-gray-300 shadow" id='temporales'>            
                <h1 class="text-green-800 text-xl text-bold p-3">Movimientos a realizar en el día</h1>
                    @foreach ($tmp_movimientos as $mov)
                        <div class=" p-2 rounded 
                        {{ $loop->odd ? 'bg-gray-100' : 'bg-white' }}
                        border-b border-gray-300">
                            <div class="grid grid-cols-6 items-center gap-2 py-2 text-gray-600">
                                <!-- Fecha: ocupa 1 de 6 -->
                                <div class="col-span-4 text-left text-sm font-semibold rounded">
                                    <button
                                    wire:click="confirmarMovimiento({{ $mov->id }})" 
                                    class="bg-green-600 py-2 px-2 text-center rounded-lg text-white text-xs font-bold uppercase">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            class="size-3"
                                            fill="none"
                                            stroke="white"
                                            stroke-width="3"
                                            stroke-linecap="round"
                                            stroke-linejoin="round">
                                        <path d="M5 13l4 4L19 7" />
                                        </svg>                                                             
                                    </button> 
                                    <button
                                    wire:click="$emit('sacarMovimiento', {{ $mov->id }})" 
                                    class="bg-red-600 py-2 px-2 text-center rounded-lg text-white text-xs font-bold uppercase">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-3">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                      </svg>                          
                                    </button> 
                                    @if ($mov->mov_tipo == 'M')
                                        Mover de {{$mov->cuenta->banco->nombre}} {{$mov->cuenta->moneda}} 
                                        a {{$mov->cuentaDestino->banco->nombre}} {{$mov->cuentaDestino->moneda}}
                                        <span class="inline-block ml-1 px-2 py-0.5 text-xs font-semibold rounded-full {{ $mov->medio_pago == 'cheque' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($mov->medio_pago ?? 'transferencia') }}
                                        </span>
                                        @if($mov->comentario)
                                            <span class="block text-xs text-gray-500 italic mt-1">{{ $mov->comentario }}</span>
                                        @endif
                                    @else
                                        {{$mov->comentario}}
                                    @endif
                                   </p>
                                </div>
                        
                                <!-- Monto: ocupa 2 de 6 -->
                                <div class="col-span-2 text-right">
                                    @if ($mov->mov_tipo == 'M')
                                    <p class="font-bold">{{ $mov->mostrar() }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class=" p-2 rounded 
                    bg-gray-100
                    border-b border-gray-300">
                        <div class="grid grid-cols-6 items-center gap-2 py-2 text-gray-600">
                            <!-- Fecha: ocupa 1 de 6 -->
                            <div class="col-span-4 text-left text-sm font-semibold rounded">  
                                <x-text-input id="comentario" class="mt-1 w-full" type="text"
                                wire:model.defer="comentario" placeholder="Ingresar Texto" />
                            </div>
                    
                            <!-- Monto: ocupa 2 de 6 -->
                            <div class="col-span-2 text-right">
                                <button
                                wire:click="$emit('agregarComentario')" 
                                    class="w-full pt-2 pb-2 h-full bg-gray-600 text-center rounded-lg text-white text-xs font-bold uppercase">
                                    Agregar                          
                                </button>  
                            </div>
                        </div>
                    </div>                   
            </div>
            <div class="mt-3 flex items-center justify-between gap-3 bg-white p-4 rounded-lg border border-gray-300 shadow">
                <div>
                    <p class="text-sm font-semibold text-gray-800">Estado de las tareas</p>
                    <p class="text-xs {{ $tareasFinalizadas ? 'text-green-700' : 'text-amber-700' }}">
                        {{ $tareasFinalizadas ? 'Publicadas para Operador.' : 'En borrador: todavía no visibles para Operador.' }}
                    </p>
                </div>
                <button
                    wire:click="finalizarYEnviarTareas"
                    class="bg-indigo-700 hover:bg-indigo-800 py-2 px-4 text-center rounded-lg text-white text-xs font-bold uppercase">
                    Finalizar y enviar tareas
                </button>
            </div>
            <div class=" bg-white p-4 mt-3 rounded-lg border border-gray-300 shadow" id='temporales'>            
                <h1 class="text-green-800 text-xl text-bold p-3">Vencimientos a abonar en el día</h1>
                    @foreach ($tmp_vencimientos as $vencimiento)
                        <div class=" p-2 rounded 
                        {{ $loop->odd ? 'bg-gray-100' : 'bg-white' }}
                        border-b border-gray-300">
                            <div class="grid grid-cols-6 items-center gap-2 py-2 text-{{ $vencimiento->rubro->color() }}-600">
                                <!-- Fecha: ocupa 1 de 6 -->
                                <div class="col-span-4 text-left text-sm font-semibold rounded">
                                    <button
                                    wire:click="confirmarVencimiento({{ $vencimiento->vencimiento_id }})" 
                                    class="bg-green-600 py-2 px-2 text-center rounded-lg text-white text-xs font-bold uppercase">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24"
                                            class="size-3"
                                            fill="none"
                                            stroke="white"
                                            stroke-width="3"
                                            stroke-linecap="round"
                                            stroke-linejoin="round">
                                        <path d="M5 13l4 4L19 7" />
                                        </svg>                                                             
                                    </button>
                                    <button
                                    wire:click="$emit('sacarVencimiento', {{ $vencimiento->vencimiento_id }})" 
                                    class="bg-red-600 py-2 px-2 text-center rounded-lg text-white text-xs font-bold uppercase">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-3">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                      </svg>                          
                                    </button> 
                                    Con {{ $vencimiento->cuenta?->banco?->nombre ?? 'Sin cuenta' }} 
                                    en {{ $vencimiento->cuenta?->moneda ?? $vencimiento->moneda }}
                                    pagar {{ $vencimiento->rubro->nombre }} (vto: {{ optional($vencimiento->vencimiento)->mostrarFechaCorta() ?? \Carbon\Carbon::parse($vencimiento->fecha)->format('d-m') }})
                                    @if($vencimiento->comentario)
                                        <span class="block text-xs text-gray-500 italic mt-0.5">{{ $vencimiento->comentario }}</span>
                                    @endif
                                    </p>
                                    
                                </div>
                        
                                <!-- Monto: ocupa 2 de 6 -->
                                <div class="col-span-2 text-right">
                                    <p class="font-bold">{{ $vencimiento->mostrar() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
        <!-- Muestro los vencimientos -->
        <div class="col-span-1 bg-white p-3" id='vencimientos'>
            <div class=" bg-white p-4 mt-1 rounded-lg border border-gray-300 shadow" id='temporales'> 
                <h1 class="text-green-800 text-xl text-bold p-3">Próximos vencimientos</h1>
                <p class="text-xs italic pb-2">Arrastra los vencimientos sobre la cuenta con la que se va a realizar el pago</p>
                <ul drag-root class="bg-white overflow-hidden rounded divide-y">                
                    @foreach ($vencimientos as $vencimiento)
                        <li drag-item="{{ $vencimiento['id'] }}" draggable="true" wire:key="{{$vencimiento['id']}}" class="cursor-move">
                            
                            <div class="grid grid-cols-6 items-center gap-2 py-3 
                            {{ $loop->odd ? 'bg-gray-50' : 'bg-white' }} 
                            text-{{ $vencimiento->rubro->color() }}-600">
                                <!-- Fecha: ocupa 1 de 6 -->
                                <div class="col-span-1 text-center text-sm font-semibold rounded">
                                    {{ $vencimiento->mostrarFechaCorta() }}
                                </div>
                        
                                <!-- Rubro: ocupa 3 de 6 -->
                                <div class="col-span-3">
                                    <p class="font-bold truncate">{{ $vencimiento->rubro->nombre }}</p>
                                    @if ($vencimiento->cuentaEstimada)
                                        <p class="text-xs italic text-gray-400 truncate">({{ $vencimiento->cuentaEstimada->banco->nombre }} {{ $vencimiento->cuentaEstimada->moneda }})</p>
                                    @endif
                                </div>
                        
                                <!-- Monto: ocupa 2 de 6 -->
                                <div class="col-span-2 text-right">
                                    <p class="font-bold">{{ $vencimiento->mostrar() }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div>    <button
        wire:click="$emit('resetear')" 
        class="bg-gray-600 py-1 px-1 text-center rounded-lg text-white text-xs font-bold uppercase">
        Resetear                          
        </button>  </div>
</div>



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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
    
<script>
    let draggingId = null;

    function inicializarDragAndDrop() {
        const root = document.querySelector('[drag-root]');
        if (!root) return;

        // 🔹 Removemos cualquier listener previo
        document.querySelectorAll('.drop-zone').forEach(zone => {
            zone.replaceWith(zone.cloneNode(true));
        });

        root.querySelectorAll('[drag-item]').forEach(el => {
            el.addEventListener('dragstart', e => {
                draggingId = el.getAttribute('drag-item');
                el.classList.add('bg-gray-200', 'opacity-30');
            });

            el.addEventListener('dragend', e => {
                el.classList.remove('bg-gray-200', 'opacity-30');
                draggingId = null;
            });
        });

        document.querySelectorAll('.drop-zone').forEach(zone => {
            zone.addEventListener('dragover', e => {
                e.preventDefault();
                zone.classList.add('bg-green-400');
            });

            zone.addEventListener('dragleave', e => {
                zone.classList.remove('bg-green-400');
            });

            zone.addEventListener('drop', e => {
                e.preventDefault();
                zone.classList.remove('bg-green-400');

                const bancoId = zone.dataset.bancoId;
                if (draggingId && bancoId) {
                    const currentDraggingId = draggingId;
                    Swal.fire({
                        title: 'Comentario del pago',
                        input: 'text',
                        inputPlaceholder: 'Ingrese un comentario (opcional)',
                        showCancelButton: true,
                        confirmButtonColor: '#166534',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Confirmar',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.emit('moverCosaABanco', currentDraggingId, bancoId, result.value || '');
                        }
                    });
                }
            });
        });
    }

    document.addEventListener('livewire:load', () => {
        inicializarDragAndDrop();
    });

    Livewire.hook('message.processed', () => {
        inicializarDragAndDrop();
    });

    Livewire.on('confirmarMovimiento', movimientoId => {
            Swal.fire({
                title: "¿Confirmar el movimiento?",
                text: "Un apartamento eliminado no se puede recuperar",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#1F2937",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, confirmar el moviento!",
                cancelButtonText: 'Cancelar'
                }).then((result) => {
            if (result.isConfirmed) {
                // eliminarla  el apartamento del  servidor
                Livewire.emit('confirmarMovimiento', movimientoId)
                Swal.fire({
                    title: "Se confirmó el movimiento",
                    text: "Eliminado correctamente.",
                    icon: "success",
                    confirmButtonColor: "#166534"
                });
            }
            });
        });
</script>
@endpush