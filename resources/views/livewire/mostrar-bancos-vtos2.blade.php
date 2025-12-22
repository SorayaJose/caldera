<div wire:init="loadRegistros" >
    @php use Illuminate\Support\Str; @endphp
    <div class="grid grid-cols-4 gap-4">
    @foreach ($bancos as $banco)
        {{$banco->buscarSaldo()}}
        <div class="flex w-full max-w-sm overflow-hidden bg-white rounded-md shadow-md outline outline-black/5  dark:bg-gray-800">
            <div class="flex items-center justify-center w-12 bg-{{$banco->color()}}-500">
                <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                </svg>
            </div>
        
            <div class="w-full space-y-2 text-center bg-gray-100 ">
                <div class="w-full text-center pt-2 bg-gray-100">
                    <span class="font-bold text-gray-700 text-xl">{{$banco->nombre}}</span>
                </div>
                <div class="flex gap-4">
                    @if (count($banco->cuentas))
                        @foreach ($banco->cuentas as $cuenta)
                            <div class="drop-zone w-1/2 pb-5 pt-5" data-banco-id="{{ $cuenta->id }}">
                                {{ $cuenta->buscarSaldo() }}
                                <p class="text-{{$cuenta->color()}}-800 font-bold text-l">{{ $cuenta->mostrarSaldo() }}</p> 
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="w-full text-left bg-white p-4">
                    @foreach ($cuenta->buscarVencimientos() as $vto)
                    <p class="text-sm">{{$vto->mostrarFecha()}} - {{ Str::limit($vto->rubro->nombre, 20) }} - {{$vto->moneda}} {{$vto->importe}}</p>
                    <button
                    wire:click="$emit('eliminarCuenta', {{ $vto->id }})" 
                    class="bg-gray-400 py-1 px-1 text-center rounded-lg text-white text-xs font-bold uppercase">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-3">
                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                      </svg>                          
                </button> 
                    @endforeach  
                </div>
            </div>
        </div>
    @endforeach
    </div>

    <div class="pt-4 w-1/2">
        <ul drag-root class="bg-white overflow-hidden rounded shadow divide-y">
            @foreach ($vencimientos as $vencimiento)
                <li drag-item={{ $vencimiento['id'] }} draggable=true wire:key="{{$vencimiento['id']}}" class=" pl-2">
                    <div class="grid grid-cols-3 gap-3">
                        <div class="flex items-center justify-center">{{$vencimiento->mostrarFecha()}}</div>
                        <div><p class="font-bold">{{ $vencimiento->rubro->nombre }}</p>
                            <p>{{ $vencimiento->concepto }}</p> 
                        </div>
                        <div class="flex items-center justify-center text-right"><p class="font-xl font-bold">{{$vencimiento->mostrar()}}</p></div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="flex items-left float-left text-left justify-left pt-3">
        <button
        wire:click="$emit('resetear')" 
        class="bg-gray-600 py-2 px-2 text-center rounded-lg text-white text-xs font-bold uppercase">
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