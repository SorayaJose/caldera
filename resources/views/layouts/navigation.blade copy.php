<nav
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)"
    :class="scrolled ? 'shadow-md' : ''"
    class="sticky top-0 z-50 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 transition-shadow duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @auth
                    @if (cache('modoSivezul') == 'S')
                    <a href="{{ route('home') }}">
                        <h1 class="text-2xl sm:text-4xl">
                            <span class=" text-sky-800 font-extrabold">Sivezul</span>
                        </h1>
                        <!-- <x-application-logo class="block h-9 w-auto fill-current text-sky-800 dark:text-gray-200" />-->
                    </a>
                    @else
                    <a href="{{ route('home') }}">
                        <h1 class="text-4xl">
                            <span class=" text-pink-800 font-extrabold">Personal</span>
                        </h1>
                    </a>
                    @endif
                    @endauth

                </div>

                @auth
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('vencimientos.index')" :active="request()->routeIs('vencimientos.index')">
                        Vencimientos
                    </x-nav-link>

                    <x-nav-link :href="route('dolares.index')" :active="request()->routeIs('dolares.index')">
                        Cotizaciones
                    </x-nav-link>

                    <x-nav-link :href="route('rubros.index')" :active="request()->routeIs('rubros.index')">
                        Conceptos
                    </x-nav-link>

                    <x-nav-link :href="route('cuentas.index')" :active="request()->routeIs('bancos.index')">
                        Cuentas
                    </x-nav-link>


                    <!--
                        <x-nav-link :href="route('gastos.index')" :active="request()->routeIs('gastos.index')">
                            Gastos
                        </x-nav-link>
                        <x-nav-link :href="route('socios.index')" :active="request()->routeIs('socios.index')">
                            Socios
                        </x-nav-link>
                         -->
                    @guest
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('login')">
                            {{ __('Iniciar session') }}
                        </x-nav-link>
                    </div>
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('register')">
                            Crear cuenta
                        </x-nav-link>
                    </div>
                    @endguest
                </div>

                @endauth
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    @if (cache('modoSivezul') == 'S')
                    <a href="{{ route('home.cambioModo') }}" class="bg-sky-800 py-3 px-4 text-center rounded-lg text-white text-xs font-extrabold uppercase">
                        Sivezul
                    </a>
                    @else
                    <a href="{{ route('home.cambioModo') }}" class="bg-pink-800 py-3 px-4 text-center rounded-lg text-white text-xs font-extrabold uppercase">
                        Personal
                    </a>
                    @endif
                @endauth

                @guest
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('login')">
                            {{ __('Iniciar session') }}
                        </x-nav-link>
                    </div>
                @endguest
            </div>

            <!-- Hamburger -->
<!-- Hamburger -->
<div class="-mr-2 flex items-center sm:hidden">
    <button
        @click="open = !open"
        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-100"
    >
        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <!-- hamburguesa -->
            <path
                :class="{ 'hidden': open, 'inline-flex': !open }"
                class="inline-flex"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
            />
            <!-- cruz -->
            <path
                :class="{ 'hidden': !open, 'inline-flex': open }"
                class="hidden"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
            />
        </svg>
    </button>
</div>

        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div
    x-show="open"
    x-cloak
    @click.outside="open = false"
    x-transition
    class="sm:hidden bg-white dark:bg-gray-800 border-t"
>


        @auth
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('vencimientos.index')" :active="request()->routeIs('vencimientos.index')">
                Vencimientos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dolares.index')" :active="request()->routeIs('dolares.index')">
                Cotizaciones
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('rubros.index')" :active="request()->routeIs('rubros.index')">
                Conceptos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('cuentas.index')" :active="request()->routeIs('cuentas.index')">
                Cuentas
            </x-responsive-nav-link>

            @if (auth()->user()->rol === 2)
            <div class="flex gap-2 items-center p-3">
                <a href="{{ route('notificaciones') }}"
                    class="w-7 h-7 bg-indigo-600 hover:bg-indigo-800 rounded-full flex flex-col 
                        justify-center items-center text-sm font-extrabold text-white">
                    {{ Auth::user()->unreadNotifications->count() }}
                </a>
                <p class="text-base font-medium text-gray-600">
                    @choice('Notificacion|Notificaciones', Auth::user()->unreadNotifications->count())
                </p>
            </div>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                            this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth

        @guest
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('login')">
                {{ __('Login') }}
            </x-responsive-nav-link>
            <!--
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('register')">
                        Crear cuenta
                    </x-responsive-nav-link>
                </div>-->
        </div>
        @endguest
    </div>
</nav>