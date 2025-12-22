<div class="flex bg-white p-5  overflow-hidden shadow-sm sm:rounded-lg">
    <div class="w-1/4 pr-4 md:justify-left">
        <p class="font-medium">Cotización</p>
        <p class="text-xs">Estos importes serán usados para los distintos cálculos.
            Se usará los últimos valores ingresados para la fecha del día. 
       </p>
    </div>
    <div class="w-3/4 md:justify-center">
        <form wire:submit.prevent='crearDolar' class="w-full space-y-5">
            <div>
                <x-input-label for="fecha" :value="__('Fecha')" />
                <x-text-input id="fecha" class="block mt-1 w-full" type="date" wire:model="fecha" 
               placeholder="Fecha de la cotización" />
                <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="brou" :value="__('Brou promedio')" />
                <x-text-input id="brou" class="block mt-1 w-full" type="text" wire:model="brou" 
                placeholder="Ingrese el valor del dolar de Brou promedio" />
                @error('brou')
                    <livewire:mostrar-alerta :message="$message" ></livewire:mostrar-alerta>        
                @enderror
            </div>

        
            <div>
                <x-input-label for="compra" :value="__('Bevsa compra')" />
                <x-text-input id="compra" class="block mt-1 w-full" type="text" wire:model="compra" 
                placeholder="Ingrese el valor de Bevsa compra" />
                @error('compra')
                    <livewire:mostrar-alerta :message="$message" ></livewire:mostrar-alerta>        
                @enderror
            </div>
        
            <div>
                <x-input-label for="venta" :value="__('Bevsa venta')" />
                <x-text-input id="venta" class="block mt-1 w-full" type="text" wire:model="venta" 
                placeholder="Ingrese el valor de Bevsa venta" />
                @error('venta')
                    <livewire:mostrar-alerta :message="$message" ></livewire:mostrar-alerta>        
                @enderror
            </div>


            <div class="flex justify-end my-2">
                <x-primary-button class="w-full justify-center">
                    {{ __('Crear cotización') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>