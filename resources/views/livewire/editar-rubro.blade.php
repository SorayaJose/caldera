<div class="flex bg-white p-5  overflow-hidden shadow-sm sm:rounded-lg">
    <div class="w-1/4 pr-4 md:justify-left">
        <p class="font-medium">Conceptos</p>
        <p class="text-xs">Los conceptos son nombres de los gastos precargados en el sistema.</p>
    </div>
    <div class="w-3/4 md:justify-center">
        <form wire:submit.prevent='editarRubro' class="w-full space-y-5">
            <div>
                <x-input-label for="nombre" :value="__('Nombre del concepto')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" wire:model="nombre" 
                placeholder="Ingrese el nombre" />
                @error('nombre')
                    <livewire:mostrar-alerta :message="$message" ></livewire:mostrar-alerta>        
                @enderror
            </div>
            
            <div>
                <x-input-label for="moneda" :value="__('Moneda por defecto')" />
                <div class="col-span-full">
                    <div class="flex gap-x-6 p-2">
                        <select wire:model="moneda" id="moneda"
                        class="block mt-1 w-full font-medium text-sm text-gray-700 dark:text-gray-300 
                        border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="$">$</option>
                        <option value="U$S">U$S</option>
                    </select>
                    </div>
                </div>
            </div>
            
            <div  class="form-group">
                <x-input-label for="banco" :value="__('Banco por defecto')" />   
                 <select wire:model="banco" name="banco" id="banco"
                 class="block mt-1 w-full font-medium text-gray-700 dark:text-gray-300 
                 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                 @if ($this->banco?->id !== null)
                        <option  value="{{$this->banco->id}}" selected>{{$this->banco->nombre}}</option>
                    @else
                        <option value="" selected>Ingrese el banco por defecto</option>
                    @endif
                    @foreach ($bancos_base as $banco_base)
                        <option  value="{{$banco_base->id}}" selected>{{$banco_base->nombre}}</option>
                    @endforeach

                </select>
            
                <x-input-error :messages="$errors->get('banco')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="color" :value="__('Forma de pago')" />
                <div class="col-span-full">
                    <div class="flex gap-x-6 p-2">
                        <select wire:model="color" id="color"
                        class="block mt-1 w-full font-medium text-sm text-gray-700 dark:text-gray-300 
                        border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Seleccione forma de pago --</option>
                        <option value="0">Se debe pagar</option>
                        <option value="1">Efectivo</option>
                        <option value="2">Transferencia</option>
                    </select>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end my-2">
                <x-primary-button class="w-full justify-center">
                    {{ __('Editar concepto') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>



