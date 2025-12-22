<div class="flex bg-white p-5  overflow-hidden shadow-sm sm:rounded-lg">
    <div class="w-1/4 pr-4 md:justify-left">
        <p class="font-medium">Bancos</p>
        <p class="text-xs">Tener en cuenta que se debe especificar la moneda de la cuenta y si es personal o no. 
            <br>El número de cuenta es opcional.
        </p>
    </div>
    <div class="w-3/4 md:justify-center">
        <form wire:submit.prevent='crearBanco' class="w-full space-y-5">
            <div>
                <x-input-label for="nombre" :value="__('Nombre del banco')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" wire:model="nombre" 
                :value="old('nombre')" placeholder="Ingrese el nombre" />
                @error('nombre')
                    <livewire:mostrar-alerta :message="$message" ></livewire:mostrar-alerta>        
                @enderror
            </div>

            <div>
                <x-input-label for="moneda" :value="__('Moneda de la cuenta')" />
                <div class="col-span-full">
                    <div class="flex gap-x-6 p-2">
                        <select wire:model="moneda" id="moneda"
                        class="block mt-1 w-full font-medium text-sm text-gray-700 dark:text-gray-300 
                        border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Seleccione moneda --</option>
                        <option value="$">$</option>
                        <option value="U$S">U$S</option>
                    </select>
                    </div>
                </div>
            </div>
            
            <div>
                <x-input-label for="tipo" :value="__('Tipo de la cuenta')" />
                <div class="col-span-full">
                    <div class="flex gap-x-6 p-2">
                        <select wire:model="tipo" id="tipo"
                        class="block mt-1 w-full font-medium text-sm text-gray-700 dark:text-gray-300 
                        border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Seleccione tipo de cuenta --</option>
                        <option value="P">Personal</option>
                        <option value="S">Sivezul</option>
                    </select>
                    </div>
                </div>
            </div>
            
            <div>
                <x-input-label for="numero" :value="__('Número de la cuenta')" />
                <x-text-input id="numero" class="block mt-1 w-full" type="text" wire:model.defer="numero" 
                :value="old('numero')" placeholder="Número de la cuenta" />
                @error('numero')
                    <livewire:mostrar-alerta :message="$message" ></livewire:mostrar-alerta>        
                @enderror
            </div>

            <div class="flex justify-end my-2">
                <x-primary-button class="w-full justify-center">
                    {{ __('Crear banco') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>