<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600 dark:text-gray-300" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:ml-10 space-x-8">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Página Inicial') }}
                    </x-nav-link>

                    @if (Auth::user()->role === 'cliente' || Auth::user()->role === 'trabalhador')
                        <x-nav-link :href="route('solicitacoes.show')" :active="request()->routeIs('solicitacoes.show')">
                            {{ __('Registro') }}
                        </x-nav-link>
                    @endif

                    @if (Auth::user()->role === 'cliente')
                        <x-nav-link :href="route('avaliacoes.cliente')" :active="request()->routeIs('avaliacoes.cliente')">
                            {{ __('Avaliar Trabalhadores') }}
                        </x-nav-link>
                    @elseif (Auth::user()->role === 'trabalhador')
                        <x-nav-link :href="route('avaliacoes.trabalhador')" :active="request()->routeIs('avaliacoes.trabalhador')">
                            {{ __('Avaliar Clientes') }}
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('avaliacoes.index')" :active="request()->routeIs('avaliacoes.index')">
                        {{ __('Minhas Avaliações') }}
                    </x-nav-link>

                    @if (Auth::user()->role === 'cliente')
                        <x-nav-link :href="route('denuncias.cliente')" :active="request()->routeIs('denuncias.cliente')">
                            {{ __('Denunciar Trabalhadores') }}
                        </x-nav-link>
                    @elseif (Auth::user()->role === 'trabalhador')
                        <x-nav-link :href="route('denuncias.trabalhador')" :active="request()->routeIs('denuncias.trabalhador')">
                            {{ __('Denunciar Clientes') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- User Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Sair') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none transition">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Página Inicial') }}
            </x-responsive-nav-link>

            @if (Auth::user()->role === 'cliente' || Auth::user()->role === 'trabalhador')
                <x-responsive-nav-link :href="route('solicitacoes.show')" :active="request()->routeIs('solicitacoes.show')">
                    {{ __('Registro') }}
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->role === 'cliente')
                <x-responsive-nav-link :href="route('avaliacoes.cliente')" :active="request()->routeIs('avaliacoes.cliente')">
                    {{ __('Avaliar Trabalhadores') }}
                </x-responsive-nav-link>
            @elseif (Auth::user()->role === 'trabalhador')
                <x-responsive-nav-link :href="route('avaliacoes.trabalhador')" :active="request()->routeIs('avaliacoes.trabalhador')">
                    {{ __('Avaliar Clientes') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('avaliacoes.index')" :active="request()->routeIs('avaliacoes.index')">
                {{ __('Minhas Avaliações') }}
            </x-responsive-nav-link>

            @if (Auth::user()->role === 'cliente')
                <x-responsive-nav-link :href="route('denuncias.cliente')" :active="request()->routeIs('denuncias.cliente')">
                    {{ __('Denunciar Trabalhadores') }}
                </x-responsive-nav-link>
            @elseif (Auth::user()->role === 'trabalhador')
                <x-responsive-nav-link :href="route('denuncias.trabalhador')" :active="request()->routeIs('denuncias.trabalhador')">
                    {{ __('Denunciar Clientes') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                    {{ Auth::user()->name }}
                </div>
                <div class="font-medium text-sm text-gray-500 dark:text-gray-300">
                    {{ Auth::user()->email }}
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Sair') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
