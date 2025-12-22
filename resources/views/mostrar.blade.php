<x-app-layout>
    <x-slot name="header">
        <div class="max-w-7xl mx-auto my-auto">
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Apartamentos') }}
                </h2>
            </div>
            <div class="flex justify-end">                    
                <a href="{{ route('apartamentos.create') }}" class="bg-green-800 py-2 px-2 text-center rounded-lg text-white text-xs font-extrabold uppercase">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="size-4">
                        <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session()->has('mensaje'))
                <div class="border border-green-600 bg-green-100 
                text-green-600 font-bold  p-2 my-3 text-sm">
                    {{ session('mensaje') }}
                </div>
            @endif

            <h1>estoy en mostrar blade</h1>
            @livewire('mostrar')
        </div>
    </div>
</x-app-layout>