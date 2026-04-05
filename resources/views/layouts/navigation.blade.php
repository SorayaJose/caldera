<nav
  x-data="{ open: false, scrolled: false }"
  x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)"
  :class="scrolled ? 'shadow-md' : ''"
  class="sticky top-0 z-50 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 transition-shadow duration-300"
>
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @auth
                        <a href="{{ Auth::user()->tienePermiso('medio') ? route('home') : route('vencimientos.index') }}">
                            <h1 class="text-2xl sm:text-4xl font-extrabold
                                {{ cache('modoSivezul') == 'S' ? 'text-sky-800' : 'text-pink-800' }}">
                                {{ cache('modoSivezul') == 'S' ? 'Sivezul' : 'Personal' }}
                            </h1>
                        </a>
                    @endauth
                </div>

                <!-- Desktop Links -->
                @auth
                @php
                    $currentUser = Auth::user();
                    $puedeGestionar = $currentUser && ($currentUser->tienePermiso('medio') || (int) ($currentUser->rol ?? 0) === \App\Models\User::ROL_ADMIN);
                    $puedeAdministrar = $currentUser && ($currentUser->tienePermiso('total') || (int) ($currentUser->rol ?? 0) === \App\Models\User::ROL_ADMIN);
                @endphp
                <div class="hidden sm:flex space-x-8 sm:ml-10">
                    <x-nav-link :href="route('vencimientos.index')" :active="request()->routeIs('vencimientos.index')">
                        Vencimientos
                    </x-nav-link>

                    <x-nav-link :href="route('vencimientos.resumen')" :active="request()->routeIs('vencimientos.resumen')">
                        Resumen semanal
                    </x-nav-link>

                    @if($puedeGestionar)
                    <x-nav-link :href="route('dolares.index')" :active="request()->routeIs('dolares.index')">
                        Cotizaciones
                    </x-nav-link>

                    <x-nav-link :href="route('cuentas.index')" :active="request()->routeIs('cuentas.index')">
                        Cuentas
                    </x-nav-link>

                    <x-nav-link :href="route('prestamos.index')" :active="request()->routeIs('prestamos.*')">
                        Préstamos
                    </x-nav-link>
                    @endif

                    <x-nav-link :href="route('cheques.index')" :active="request()->routeIs('cheques.index')">
                        Cheques
                    </x-nav-link>

                    @if($puedeGestionar)
                    <!-- Dropdown Varios -->
                    <div class="relative" x-data="{ openVarios: false }" @click.outside="openVarios = false">
                        <button @click="openVarios = !openVarios"
                            class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out
                                {{ request()->routeIs('rubros.*') || request()->routeIs('mantenimiento.*') || request()->routeIs('usuarios.*') || request()->routeIs('movimientos.*')
                                    ? 'border-indigo-400 dark:border-indigo-600 text-gray-900 dark:text-gray-100 focus:border-indigo-700'
                                    : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700' }}">
                            Varios
                            <svg class="ml-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293L10 12l4.707-4.707" clip-rule="evenodd"/>
                            </svg>
                        </button>

                        <div x-show="openVarios"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 z-50">
                            <div class="py-1">
                                @if($puedeGestionar)
                                <a href="{{ route('mantenimiento.importar') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600
                                       {{ request()->routeIs('mantenimiento.*') ? 'font-semibold bg-gray-50 dark:bg-gray-600' : '' }}">
                                    Mantenimiento
                                </a>
                                @endif
                                @if($puedeAdministrar)
                                <a href="{{ route('usuarios.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600
                                       {{ request()->routeIs('usuarios.*') ? 'font-semibold bg-gray-50 dark:bg-gray-600' : '' }}">
                                    Usuarios
                                </a>
                                @endif
                                <a href="{{ route('rubros.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600
                                       {{ request()->routeIs('rubros.*') ? 'font-semibold bg-gray-50 dark:bg-gray-600' : '' }}">
                                    Conceptos
                                </a>
                                <a href="{{ route('movimientos.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600
                                       {{ request()->routeIs('movimientos.*') ? 'font-semibold bg-gray-50 dark:bg-gray-600' : '' }}">
                                    Movimientos
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endauth
            </div>

            <!-- Right Desktop -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-3">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md
                                text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800
                                hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition">
                                {{ Auth::user()->name }}
                                <svg class="ml-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293L10 12l4.707-4.707"
                                          clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Perfil
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar sesión
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>

                    @if($puedeGestionar)
                    <a href="{{ route('home.cambioModo') }}"
                       class="px-4 py-2 rounded-lg text-xs font-extrabold uppercase text-white
                       {{ cache('modoSivezul') == 'S' ? 'bg-sky-800' : 'bg-pink-800' }}">
                        {{ cache('modoSivezul') == 'S' ? 'Sivezul' : 'Personal' }}
                    </a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                        class="p-2 rounded-md text-gray-400 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open }" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{ 'hidden': !open }" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden bg-white dark:bg-gray-800 border-t">
        @auth
        @php
            $currentUser = Auth::user();
            $puedeGestionar = $currentUser && ($currentUser->tienePermiso('medio') || (int) ($currentUser->rol ?? 0) === \App\Models\User::ROL_ADMIN);
            $puedeAdministrar = $currentUser && ($currentUser->tienePermiso('total') || (int) ($currentUser->rol ?? 0) === \App\Models\User::ROL_ADMIN);
        @endphp
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('vencimientos.index')">Vencimientos</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('vencimientos.resumen')">Resumen semanal</x-responsive-nav-link>
            @if($puedeGestionar)
            <x-responsive-nav-link :href="route('prestamos.index')">Préstamos</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dolares.index')">Cotizaciones</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cuentas.index')">Cuentas</x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('cheques.index')">Cheques</x-responsive-nav-link>
            @if($puedeGestionar)
            <div class="px-4 pt-2 pb-1 text-xs font-semibold uppercase text-gray-400 dark:text-gray-500 tracking-wider">Varios</div>
            @if($puedeGestionar)
            <x-responsive-nav-link :href="route('mantenimiento.importar')">Mantenimiento</x-responsive-nav-link>
            @endif
            @if($puedeAdministrar)
            <x-responsive-nav-link :href="route('usuarios.index')">Usuarios</x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('rubros.index')">Conceptos</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('movimientos.index')">Movimientos</x-responsive-nav-link>
            @endif
        </div>

        <div class="border-t pt-4 pb-2">
            <div class="px-4 text-sm text-gray-600">
                {{ Auth::user()->name }}<br>
                {{ Auth::user()->email }}
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Perfil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>
