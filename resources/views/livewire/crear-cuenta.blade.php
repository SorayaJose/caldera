<div class="flex bg-white p-5  overflow-hidden shadow-sm sm:rounded-lg">
    <div class="w-1/4 pr-4 md:justify-left">
        <p class="font-medium">Cuentas</p>
        <p class="text-xs">Tener en cuenta que se debe especificar la moneda de la cuenta y si es personal o no. 
            <br>El número de cuenta es opcional. 
        </p>
    </div>
    
    <div class="w-3/4 md:justify-center">
        <form wire:submit.prevent='crearCuenta' class="w-full space-y-5">
            <div>
                <x-input-label for="banco" :value="__('Nombre del banco')" />
                <select wire:model="banco" id="banco"
                    class="block mt-1 w-full font-medium text-sm text-gray-700 dark:text-gray-300 
                    border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">-- Seleccione --</option>
                    @foreach ($bancos as $banco)
                        <option value="{{ $banco->id }}">{{ $banco->nombre }}</option>
                    @endforeach
                </select>
                @error('banco')
                    <livewire:mostrar-alerta :message="$message" ></livewire:mostrar-alerta>        
                @enderror
            </div>

            {{--
            <div>
                <x-input-label for="banco" :value="__('Nombre del banco')" />
                <div class="col-span-full">
                    <div class="flex gap-x-6 p-2">
                        <select wire:model="banco" id="banco"
                        class="block mt-1 w-full font-medium text-sm text-gray-700 dark:text-gray-300 
                        border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Seleccione el nombre de banco --</option>
                        <option value="C">Scotiabank</option>
                        <option value="S">Santander</option>
                        <option value="B">Brou</option>
                        <option value="I">Itaú</option>
                        <option value="H">HSBC</option>
                        <option value="V">BBVA</option>
                        <option value="J">Caja</option>
                        </select>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('banco')" class="mt-2" />
            </div>
            --}}

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
                <x-input-error :messages="$errors->get('moneda')" class="mt-2" />
            </div>
            
    
            {{-- 
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
            --}}
            
            <div>
                <x-input-label for="numero" :value="__('Número de la cuenta')" />
                <x-text-input id="numero" class="block mt-1 w-full" type="text" wire:model.defer="numero" 
                :value="old('numero')" placeholder="Número de la cuenta" />
                <x-input-error :messages="$errors->get('numero')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="saldo" :value="__('Saldo de la cuenta')" />
                <x-text-input id="saldo" class="block mt-1 w-full" type="text" wire:model="saldo" 
                :value="old('saldo')" placeholder="Ingrese el saldo inicial" />
                <x-input-error :messages="$errors->get('saldo')" class="mt-2" />
            </div>    
            
            <div class="flex justify-end my-2">
                <x-primary-button class="w-full justify-center">
                    {{ __('Crear cuenta') }} 
                </x-primary-button>
            </div>
        </form>
    </div>
</div>