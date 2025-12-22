<x-app-layout>
    <x-slot name="header">
        <div class="w-full text-gray-900 dark:text-gray-100 md:flex md:justify-between md:items-center">
            <div class="px-2 py-2 w-full flex items-center  justify-between">
                <div class="justify-right">
                    <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        Bancos
                    </h1>
                </div>
                <div class="justify-right">
                    <a href="{{ route('bancos.create') }}" class="bg-green-800 py-3 px-4 text-center rounded-lg text-white text-xs font-extrabold uppercase">
                        Nuevo
                    </a> 
                </div>    
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             @if (session()->has('mensaje'))

                <div class='text-normal text-green-800 dark:text-green-800 space-y-2 mb-4'>
                    <p class="bg-green-200 border-l-4 border-green-800 text-green-800 font-bold p-4">
                        {{ session('mensaje') }}
                    </p>
                </div>

            @endif

            @livewire('mostrar-bancos')
        </div>
    </div>
</x-app-layout>