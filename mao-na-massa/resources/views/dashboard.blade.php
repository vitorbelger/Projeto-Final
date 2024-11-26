<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <!-- Título da Lista -->
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Lista de Trabalhadores Disponíveis') }}
                </h2>
            </div>

            <!-- Barra de Pesquisa -->
            <div class="mt-6">
                <form method="GET" action="{{ route('dashboard') }}" class="flex items-center">
                    <input type="text" name="search" placeholder="Pesquisar por nome ou profissão..."
                        class="w-full px-4 py-2 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300
                               focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ request('search') }}" />
                    <button type="submit"
                        class="ml-3 px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md
                            hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        {{ __('Buscar') }}
                    </button>
                </form>
            </div>

            <!-- Lista de Trabalhadores -->
            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($workers as $worker)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ $worker->user->name }}
                            <span class="text-yellow-500 text-sm">
                                ({{ number_format($worker->user->mediaAvaliacoes() ?? 0, 1) }} / 5)
                            </span>
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $worker->profissao }}
                        </p>
                        <a href="{{ route('workers.show', $worker->id) }}"
                            class="mt-4 inline-block text-indigo-600 dark:text-indigo-400 hover:underline">
                            {{ __('Ver Detalhes') }}
                        </a>
                    </div>
                @empty
                    <div class="col-span-full">
                        <p class="text-center text-gray-600 dark:text-gray-400">
                            {{ __('Nenhum trabalhador encontrado.') }}
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
