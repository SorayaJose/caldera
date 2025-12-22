<x-app-layout>
    <x-slot name="header">
        <div class="w-full text-gray-900 dark:text-gray-100 md:flex md:justify-between md:items-center">
            <div class="px-2 py-2 w-full flex items-center  justify-between">
                <div class="justify-right">
                    <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Crear una cotización
                    </h1>
                </div>
                <div class="justify-right">
                    <a href="{{ route('dolares.index') }}" class="bg-green-800 py-3 px-4 text-center rounded-lg text-white text-xs font-extrabold uppercase">
                        Listado de cotizaciones 
                    </a> 
                </div>    
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:crear-dolar />   
        </div>
    </div>
</x-app-layout>