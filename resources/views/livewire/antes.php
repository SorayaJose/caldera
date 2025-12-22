<div wire:init="loadRegistros">

    @if (count($bancos))
        @foreach ($bancos as $banco)
            <div class="flex w-full mb-3 overflow-hidden bg-white rounded-lg shadow-md"
                drop-target
                data-banco-id="{{ $banco->id }}">
                <div class="contenedor-cosas">
                    <!-- Aquí se agregarán las cosas soltadas -->
                </div>
                @if ($banco->saldo() > 0)
                    <div class="flex items-center justify-center w-12 bg-emerald-500">
                        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                        </svg>
                    </div>
                @else
                    <div class="flex items-center justify-center w-12 bg-red-500">
                        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z" />
                        </svg>
                    </div>
                @endif
            
                <div class="px-4 py-2 w-4/5">
                    <div class="mx-3">
                        <p class="text-sm text-gray-600">
                            <span class="font-bold text-2xl  text-gray-800">
                                {{$banco->nombre}}
                                <p class="text-xl text-gray-800">en {{$banco->moneda}} - Nro Cuenta: {{$banco->numero}}</p>
                            </span>
                        </p>
                    </div>
                </div>

                <div class="px-4 py-2 w-1/5">
                    <div class="mx-3 text-right">
                        <span class="font-bold text-2xl  text-red-600">
                            {{$banco->mostrarSaldo()}}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

</div>

<div>
    <ul drag-root class="overflow-hidden rounded shadow divide-y">
        @foreach ($cosas as $cosa)
        <li drag-item draggable=true wire:key="{{$cosa['id']}}" class="w-64 p-4" data-cosa-id="{{$cosa['id']}}">
            {{$cosa['nombre']}}
        </li>      
        @endforeach
    </ul>
</div>


@push('scripts')
<script>
    
    document.addEventListener('DOMContentLoaded', () => {
        let draggingCosaId = null;

        // Inicializar drag para cada cosa
        document.querySelectorAll('[drag-item]').forEach(el => {
            el.addEventListener('dragstart', e => {
                draggingCosaId = el.dataset.cosaId;
                e.dataTransfer.effectAllowed = "move";
                e.target.classList.add('opacity-50');
            });

            el.addEventListener('dragend', e => {
                draggingCosaId = null;
                e.target.classList.remove('opacity-50');
            });
        });

        // Inicializar drop para cada banco
        document.querySelectorAll('[drop-target]').forEach(el => {
            el.addEventListener('dragover', e => {
                e.preventDefault(); // Necesario para permitir el drop
                el.target.classList.add('bg-yellow-100');
            });

            el.addEventListener('dragleave', e => {
                el.target.classList.remove('bg-yellow-100');
            });

            el.addEventListener('drop', e => {
                e.preventDefault();
                el.target.classList.remove('bg-yellow-100');
                console.log('antes Emitiendo evento: asociarCosaABanco');

                const bancoId = el.dataset.bancoId;

                if (draggingCosaId && bancoId) {
                    // Mover visualmente la cosa al contenedor del banco (si existe)
                    const cosaEl = document.querySelector(`[drag-item][data-cosa-id="${draggingCosaId}"]`);
                    const contenedor = el.querySelector('.contenedor-cosas');

                    if (cosaEl && contenedor) {
                        contenedor.appendChild(cosaEl);
                    }

                    // Emitir evento a Livewire
                    console.log('Emitiendo evento: asociarCosaABanco', draggingCosaId, bancoId);
                    Livewire.emitTo('mostrar-bancos-vtos', 'asociarCosaABanco', draggingCosaId, bancoId);
                    //Livewire.emit('asociarCosaABanco', draggingCosaId, bancoId);
                    console.log('se envio: asociarCosaABanco', draggingCosaId, bancoId);
                }
            });
        });
    });
</script>
@endpush
ß