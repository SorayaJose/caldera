<div wire:init="loadRegistros" >
    @php use Illuminate\Support\Str; @endphp
    {{-- 
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-4 lg:gap-8">
        <div class="h-16 rounded bg-gray-300 lg:col-span-2">
            <div class="grid grid-cols-4 items-center justify-center">
                <div class="flex items-center justify-center w-12 bg-blue-500">
                    <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                    </svg>
                </div>
                <div class="w-full col-span-3 text-center pt-2 bg-gray-100">
                    <span class="font-bold text-gray-700 text-xl">Santander</span>
                </div>
            </div>
        </div>
        <div class="h-24 rounded bg-gray-300"></div>
        <div class="h-24 rounded bg-gray-300"></div>
    </div>
    --}}
    <div class="grid grid-cols-3 gap-4 bg-yellow-100">
        <!-- Div que ocupa 2/3 -->
        <div class="col-span-2 bg-white p-4 rounded-lg shadow">
          Contenido principal (2/3)
        </div>
      
        <!-- Div que ocupa 1/3 -->
        <div class="col-span-1 bg-gray-200 p-4 rounded-lg shadow">
          Contenido secundario (1/3)
        </div>
      </div>
      
    <div class="grid grid-cols-6 gap-4 bg-red-100 p-3">

        @if (count($cuentas))
            @foreach ($cuentas as $cuenta)
                <div class="bg-green-100">
                    [{{ $cuenta->id }}]{{ $cuenta->banco->nombre}}
                    {{ $cuenta->moneda }}
                    {{ $cuenta->numero }}
                    <p class="text-{{$cuenta->color()}}-800">{{ number_format($cuenta->saldo, 2, ',', '.') }}</p>
                </div>
            @endforeach
        @endif
    </div>

    <div class="grid grid-cols-3 gap-4">
    @foreach ($bancos as $banco)
        {{--$banco->buscarSaldo()--}}
        <div class="flex w-full max-w-sm overflow-hidden bg-gray-50 rounded-md shadow-md outline outline-black/5  dark:bg-gray-800">
            <div class="flex items-center justify-center w-12 bg-{{$banco->color()}}-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                </svg>
            </div>
        
            <div class="w-full space-y-2 text-center ">
                <div class="w-full text-center pt-2 pb-2 border-b border-gray-200">
                    <span class="font-bold text-gray-700 text-xl">{{$banco->nombre}}</span>
                </div>
                <div class="flex gap-2 border-b border-gray-200">
                    @if (count($banco->cuentas))
                        @foreach ($banco->cuentas as $cuenta)
                            <div class="drop-zone w-1/2 pb-5 pt-5" data-banco-id="{{ $cuenta->id }}">
                                {{ $cuenta->buscarSaldo() }}
                                <p>Id: {{ $cuenta->id }}</p>
                                <p class="text-{{$cuenta->color()}}-800 font-bold text-l">mostrarSaldo{{-- $cuenta->mostrarSaldo() --}}</p> 
                                {{-- <p>{{$cuenta->buscarSaldoDebug()}}</p>--}}
                            </div>
                            
                        @endforeach
                    @endif
                </div>

                <div class="w-full text-left  p-4">
                    aca tendria que ir lo que comente
                    {{-- 
                    @foreach ($cuenta->buscarVencimientos() as $vto)
                        <div class="grid grid-cols-8 gap-4">
                            <div class="col-span-7"><p class="text-sm text-{{$vto->rubro->color()}}-800">{{$vto->mostrarFechaCorta()}} - {{ Str::limit($vto->rubro->nombre, 20) }} - {{$vto->moneda}} {{$vto->importe}}</p></div>
                            <div>
                                <button
                                wire:click="$emit('eliminarCuenta', {{ $vto->id }})" 
                                class="bg-gray-400 py-1 px-1 text-center rounded-lg text-white text-xs font-bold uppercase">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-3">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                </svg>                          
                            </button> 
                            </div>
                        </div>
                    @endforeach  
                    --}}
                </div>
            </div>

        </div>
    @endforeach


    </div>

    
    <div class="grid grid-cols-2 gap-3">
        <div class="pt-4">
            <ul drag-root class="bg-white overflow-hidden rounded shadow divide-y">
                @foreach ($vencimientos as $vencimiento)
                    <li drag-item={{ $vencimiento['id'] }} draggable=true wire:key="{{$vencimiento['id']}}" class=" pl-2">
                        <div class="grid grid-cols-3 gap-3 text-{{$vencimiento->rubro->color()}}-800">
                            <div class="flex items-center justify-center ">{{$vencimiento->mostrarFecha()}}</div>
                            <div><p class="font-bold">{{ $vencimiento->rubro->nombre }}</p>
                                <p>{{ $vencimiento->concepto }}</p> 
                            </div>
                            <div class="flex items-center justify-center text-right"><p class="font-xl font-bold">{{$vencimiento->mostrar()}}</p></div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="pt-4">
            <div class="grid grid-row5 p-2 bg-gray-50 rounded-md shadow-md outline outline-black/5  dark:bg-gray-800">
                <div class=""><p class="text-m">Mover:</p></div>
                <div>
                    <select wire:model="origen" name="origen" id="origen"
                    class="block mt-1 w-full font-medium text-gray-700 dark:text-gray-300 
                    border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option  value="0" selected>Efectivo</option>
                        <option  value="99" selected>Cheque</option>
                       @foreach ($bancos as $banco)
                           <option  value="{{$banco->id}}" selected>{{$banco->nombre}}</option>
                       @endforeach               
                   </select>
                </div>
                <div class="pt-2 pb-2">
                    <select wire:model="destino" name="destino" id="destino"
                    class="block mt-1 w-full font-medium text-gray-700 dark:text-gray-300 
                    border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option  value="0" selected>Efectivo</option>
                        <option  value="99" selected>Cheque</option>
                       @foreach ($bancos as $banco)
                           <option value="{{$banco->id}}" selected>{{$banco->nombre}}</option>
                       @endforeach               
                   </select>
                </div>
                <div class="pb-3">
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
                <div class="">
                    <button
                    wire:click="$emit('movimiento')" 
                        class="w-full pt-2 pb-2 h-full bg-gray-600 text-center rounded-lg text-white text-xs font-bold uppercase">
                        Planificar movimiento                          
                    </button>  
                </div>
            </div>
            <p>
                @foreach ($tmp_vencimientos as $tmp)
                    <p>{{$tmp->mostrar()}}</p>
                @endforeach
            </p>
        </div>
    </div>

    <div class="flex items-left float-left text-left justify-left pt-3">
        <button
        wire:click="$emit('resetear')" 
        class="bg-gray-600 py-1 px-1 text-center rounded-lg text-white text-xs font-bold uppercase">
        Resetear                          
    </button>   
    </div>
</div>


@push('scripts')
<script>
    let draggingId = null;

    function inicializarDragAndDrop() {
        const root = document.querySelector('[drag-root]');
        if (!root) return;

        root.querySelectorAll('[drag-item]').forEach(el => {
            el.addEventListener('dragstart', e => {
                draggingId = el.getAttribute('drag-item');
                el.classList.add('bg-gray-200');
                el.classList.add('opacity-30');
            });

            el.addEventListener('dragend', e => {
                el.classList.remove('bg-gray-200');
                el.classList.remove('opacity-30');
                draggingId = null;
            });
        });

        document.querySelectorAll('.drop-zone').forEach(zone => {
            zone.addEventListener('dragover', e => {
                e.preventDefault();
                zone.classList.add('bg-green-400');
                //console.log("Over banco");
            });

            zone.addEventListener('dragenter', e => {
                zone.classList.add('bg-green-400');
                //console.log("Enter banco");
            });

            zone.addEventListener('dragleave', e => {
                zone.classList.remove('bg-green-400');
            });

            zone.addEventListener('drop', e => {
                e.preventDefault();
                zone.classList.remove('bg-green-400');

                const bancoId = zone.dataset.bancoId;
                //console.log('Drop en banco ID:', bancoId);

                if (draggingId && bancoId) {
                    Livewire.emit('moverCosaABanco', draggingId, bancoId);
                }
            });
        });
    }

    // Inicialización inicial
    document.addEventListener('livewire:load', () => {
        inicializarDragAndDrop();
    });

    // Re-asignar eventos después de cada actualización del DOM de Livewire
    Livewire.hook('message.processed', (message, component) => {
        inicializarDragAndDrop();
    });
</script>
@endpush