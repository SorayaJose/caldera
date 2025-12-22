<section class="p-4 dark:bg-gray-100 dark:text-gray-900">
        <fieldset class="grid grid-cols-4 gap-6 p-6 rounded-md shadow-sm dark:bg-gray-50">
            <div class="space-y-2 col-span-full lg:col-span-1">
                <p class="font-medium">Nombre del rubro</p>
                <p class="text-xs">Texto que identifica el tipo de rubro.</p>
            </div>
            <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                <div class="col-span-full">
                    <label for="nombre" class="text-sm">Nombre</label>
                    <input id="Nombre" type="text" placeholder="Nombre del texto" class="w-full rounded-md focus:ring focus:ring-opacity-75 dark:text-gray-50 focus:dark:ring-violet-600 dark:border-gray-300">
                </div>
            </div>

        </fieldset>

        <fieldset class="grid grid-cols-4 gap-6 p-6 rounded-md shadow-sm dark:bg-gray-50">

            <div class="space-y-2 col-span-full lg:col-span-1">
                <p class="font-medium">Moneda por defecto</p>
                <p class="text-xs">Es la moneda en la que se va a pagar este rubro en la mayoria de los casos.
                    Se puede modificar después.
                </p>
            </div>
            <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3">
                <div class="col-span-full">
                    <div class="flex gap-x-6">
                        <div class="flex">
                            <input type="radio" name="hs-radio-group" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-group-1" checked="">
                            <label for="hs-radio-group-1" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">$</label>
                        </div>
                        
                        <div class="flex">
                            <input type="radio" name="hs-radio-group" class="shrink-0 mt-0.5 border-gray-200 rounded-full text-blue-600 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-radio-group-2">
                            <label for="hs-radio-group-2" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">U$S</label>
                        </div>
                        </div>
                </div>
    

            </div>
        </fieldset>

        <fieldset class="grid grid-cols-4 gap-6 pt-2 pb-4 rounded-md shadow-sm dark:bg-gray-50">
            <div class="space-y-2 col-span-full lg:col-span-1 bg-violet-250">
                &nbsp;
            </div>
            <div class="grid grid-cols-6 gap-4 col-span-full lg:col-span-3 bg-green-300">
                <x-primary-button class="w-full col-span-full justify-center">
                    {{ __('Crear rubro') }}
                </x-primary-button>
            </div>
        </fieldset>
    </section>
