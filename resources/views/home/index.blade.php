<x-app-layout>
    <x-slot name="header">
        <div class="w-full text-gray-900 dark:text-gray-100 md:flex md:justify-between md:items-center">
            <div class="w-full rounded-lg border border-gray-300 p-6">
                <div class="w-full flex items-center justify-between">
                    <!-- Bloque central -->
                    <div class="flex items-center justify-center gap-8 w-3/4">
                        <div class="text-center border-r border-gray-300 pr-6">
                            <p class="text-sm">Cotización de:</p>
                            <p class="text-xl font-bold">{{ $dolar->mostrarFecha() }}</p> 
                        </div>
                        <div class="text-center border-r border-gray-300 pr-6">
                            <p class="text-sm font-bold">BROU:</p>
                            <p class="text-xl">{{ $dolar->mostrarBrou() }}</p> 
                        </div>
                        <div class="text-center border-r border-gray-300 pr-6">
                            <p class="text-sm font-bold">BEVSA Compra:</p>
                            <p class="text-xl">{{ $dolar->mostrarCompra() }}</p> 
                        </div>
                        <div class="text-center border-r border-gray-300 pr-6">
                            <p class="text-sm font-bold">BEVSA Venta:</p>
                            <p class="text-xl">{{ $dolar->mostrarVenta() }}</p> 
                        </div>
                    </div>
                
                    <!-- Botón a la derecha -->
                    <div>
                        <a href="{{ route('dolares.create') }}" class="bg-green-800 py-3 px-4 text-center rounded-lg text-white text-xs font-extrabold uppercase">
                            Ingreso de cotización del día
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             @if (session()->has('mensaje'))

                <div class='text-normal text-green-800 dark:text-green-800 space-y-2 mb-4'>
                    <p class="bg-green-200 border-l-4 border-green-800 text-green-800 font-bold p-4">
                        {{ session('mensaje') }}
                    </p>
                </div>

            @endif

            @livewire('mostrar-bancos-vtos')
        </div>
    </div>
</x-app-layout>