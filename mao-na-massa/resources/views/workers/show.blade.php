<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes do Trabalhador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">{{ $worker->user->name }}</h3>
                    <p><strong>Telefone:</strong>{{ $worker->user->telefone }}</p>
                    <p><strong>Endereço:</strong>{{ $worker->user->endereco }}</p>
                    <p><strong>Profissão:</strong> {{ $worker->profissao }}</p>
                    <p><strong>Currículo:</strong> {{ $worker->curriculo }}</p>

                    <form action="{{ route('workers.solicitar', $worker->id) }}" method="POST" class="mt-4">
                        @csrf
                        {{-- Data de Início --}}
                        <label for="data_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Data de Início:
                        </label>
                        <input type="date" name="data_inicio" id="data_inicio" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900
                                   dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600
                                   focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            value="{{ old('data_inicio') }}">
                        @error('data_inicio')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        {{-- Data de Conclusão --}}
                        <label for="data_conclusao" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Data de Conclusão:
                        </label>
                        <input type="date" name="data_conclusao" id="data_conclusao" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900
                                   dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600
                                   focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            value="{{ old('data_conclusao') }}">
                        @error('data_conclusao')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        {{-- Descrição --}}
                        <label for="descricao" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-4">
                            Descrição:
                        </label>
                        <textarea name="descricao" id="descricao" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900
                                  dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600
                                  focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('descricao') }}</textarea>
                        @error('descricao')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <button type="submit"
                            class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            Solicitar Serviço
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
