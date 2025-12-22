// me funciona 

<div>
    <ul drag-root class="overflow-hidden rounded shadow divide-y">
        @foreach ($cosas as $cosa)
            <li drag-item={{ $cosa['id'] }} draggable=true wire:key="{{$cosa['id']}}" class="w-64 p-4">
                {{$cosa['nombre']}}
            </li>
        @endforeach
    </ul>
</div>

@push('scripts')
<script>
    
    document.addEventListener('livewire:load', () => {
        const root = document.querySelector('[drag-root]');

        root.querySelectorAll('[drag-item]').forEach(el => {
            el.addEventListener('dragstart', e  => {
                e.target.setAttribute('dragging', true);
            });

            el.addEventListener('drop', e => {
                window.alert("estoy");
                e.currentTarget.classList.remove('bg-yellow-100');
                let draggingEl = root.querySelector('[dragging]');

                if (draggingEl && draggingEl !== e.currentTarget) {
                    e.currentTarget.before(draggingEl);

                    const nuevoOrden = Array.from(root.querySelectorAll('[drag-item]'))
                        .map(el => el.getAttribute('wire:key'));

                    Livewire.emit('actualizarOrden');
                }
            });

            el.addEventListener('dragenter', e => {
                e.currentTarget.classList.add('bg-yellow-100');
                e.preventDefault();
            });

            el.addEventListener('dragover', e => e.preventDefault());
            el.addEventListener('dragleave', e => e.currentTarget.classList.remove('bg-yellow-100'));
            el.addEventListener('dragend', e => e.target.removeAttribute('dragging'));
        });
    });
</script>
@endpush


// propuesto por chatgpt

@push('scripts')
<script>
    document.addEventListener('livewire:load', () => {
        const root = document.querySelector('[drag-root]');

        // Guardar el ID del item que se está arrastrando
        let draggingId = null;

        root.querySelectorAll('[drag-item]').forEach(el => {
            el.addEventListener('dragstart', e => {
                draggingId = el.getAttribute('drag-item');
            });

            el.addEventListener('dragend', e => {
                draggingId = null;
            });
        });

        // Zonas de drop = los bancos
        document.querySelectorAll('.drop-zone').forEach(zone => {
            zone.addEventListener('dragover', e => e.preventDefault());

            zone.addEventListener('dragenter', e => {
                e.currentTarget.classList.add('bg-green-100');
            });

            zone.addEventListener('dragleave', e => {
                e.currentTarget.classList.remove('bg-green-100');
            });

            zone.addEventListener('drop', e => {
                e.preventDefault();
                e.currentTarget.classList.remove('bg-green-100');

                const bancoId = e.currentTarget.dataset.bancoId;

                if (draggingId && bancoId) {
                    // Aquí puedes emitir un evento Livewire o hacer un fetch/AJAX
                    Livewire.emit('moverCosaABanco', draggingId, bancoId);
                }
            });
        });
    });
</script>
@endpush


CREATE TABLE `vencimientos` (
    `id` bigint(20) un...localhost/caldera/		http://localhost/phpmyadmin/index.php?route=/table/sql&db=caldera&table=KEY_COLUMN_USAGE
    Su consulta se ejecutó con éxito.
    
    SHOW CREATE TABLE vencimientos;
    
    
    
    vencimientos	CREATE TABLE `vencimientos` (
      `id` bigint(20) un...	
     localhost/caldera/		http://localhost/phpmyadmin/index.php?route=/table/sql&db=caldera&table=KEY_COLUMN_USAGE
     Su consulta se ejecutó con éxito.
     
     SHOW CREATE TABLE vencimientos;
     
     
     
     vencimientos	CREATE TABLE `vencimientos` (
       `id` bigint(20) un...	
     