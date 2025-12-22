<div class="flex bg-white p-5  overflow-hidden shadow-sm sm:rounded-lg">
    <div class="w-1/4 pr-4 md:justify-left">
        <p class="font-medium">Vencimiento</p>
        <p class="text-xs">Los vencimientos son debes a pagar en un futuro.</p>
    </div>
    <div class="w-3/4 md:justify-center">
        <form wire:submit.prevent='crearVencimiento' class="w-full space-y-5">
            <div>
                <x-input-label for="fecha" :value="__('Fecha de pago')" />
                <x-text-input id="fecha" class="block mt-1 w-full" type="date" wire:model="fecha" 
                :value="old('fecha')" placeholder="Fecha de pago" />
                <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
            </div>

            <div  class="form-group">
                <x-input-label for="rubro" :value="__('Concepto a pagar')" />   
                 <select wire:model="rubro" name="rubro" id="rubro"
                 class="block mt-1 w-full font-medium text-gray-700 dark:text-gray-300 
                 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="" selected>Ingrese el concepto</option>
                    @foreach ($rubros as $rubro_base)
                        <option  value="{{$rubro_base->id}}">{{$rubro_base->nombre}}</option>
                    @endforeach
                </select>
            
                <x-input-error :messages="$errors->get('rubro')" class="mt-2" />
            </div>
            
            {{-- 
            <div>
                <x-input-label for="concepto" :value="__('Comentario')" />
                <x-text-input id="concepto" class="block mt-1 w-full" type="text" wire:model="concepto" 
                :value="old('concepto')" placeholder="Ingrese un texto significativo del pago" />
                @error('concepto')
                    <livewire:mostrar-alerta :message="$message" ></livewire:mostrar-alerta>        
                @enderror
            </div> 
            --}}

            <div>
                <x-input-label for="moneda" :value="__('Moneda')" />
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
                <x-input-label for="importe" :value="__('Importe a pagar')" />
                <x-text-input id="importe" class="block mt-1 w-full" type="text" wire:model="importe" 
                :value="old('importe')" placeholder="Ingrese el importe a pagar" />
                @error('importe')
                    <livewire:mostrar-alerta :message="$message" ></livewire:mostrar-alerta>        
                @enderror
            </div>
            
            <div class="flex justify-end my-2">
                <x-primary-button class="w-full justify-center">
                    {{ __('Crear vencimiento') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
