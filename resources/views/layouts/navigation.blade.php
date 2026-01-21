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
                        <a href="{{ route('home') }}">
                            <h1 class="text-2xl sm:text-4xl font-extrabold
                                {{ cache('modoSivezul') == 'S' ? 'text-sky-800' : 'text-pink-800' }}">
                                {{ cache('modoSivezul') == 'S' ? 'Sivezul' : 'Personal' }}
                            </h1>
                        </a>
                    @endauth
                </div>

                <!-- Desktop Links -->
                @auth
                <div class="hidden sm:flex space-x-8 sm:ml-10">
                    <x-nav-link :href="route('vencimientos.index')" :active="request()->routeIs('vencimientos.index')">
                        Vencimientos
                    </x-nav-link>

                    <x-nav-link :href="route('movimientos.index')" :active="request()->routeIs('movimientos.index')">
                        Movimientos
                    </x-nav-link>
                    
                    <x-nav-link :href="route('dolares.index')" :active="request()->routeIs('dolares.index')">
                        Cotizaciones
                    </x-nav-link>

                    <x-nav-link :href="route('rubros.index')" :active="request()->routeIs('rubros.index')">
                        Conceptos
                    </x-nav-link>

                    <x-nav-link :href="route('cuentas.index')" :active="request()->routeIs('cuentas.index')">
                        Cuentas
                    </x-nav-link>
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

                    <a href="{{ route('home.cambioModo') }}"
                       class="px-4 py-2 rounded-lg text-xs font-extrabold uppercase text-white
                       {{ cache('modoSivezul') == 'S' ? 'bg-sky-800' : 'bg-pink-800' }}">
                        {{ cache('modoSivezul') == 'S' ? 'Sivezul' : 'Personal' }}
                    </a>
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
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('vencimientos.index')">Vencimientos</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dolares.index')">Cotizaciones</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('rubros.index')">Conceptos</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('movimientos.index')">Movimientos</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cuentas.index')">Cuentas</x-responsive-nav-link>
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
