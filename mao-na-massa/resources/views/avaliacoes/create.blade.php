<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Avaliar Solicitação #{{ $solicitacao->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Detalhes do Avaliado</h3>
                    <p><strong>Nome:</strong>
                        {{ auth()->id() === $solicitacao->user_id ? $solicitacao->worker->user->name : $solicitacao->cliente->name }}
                    </p>

                    <form method="POST" action="{{ route('avaliacoes.store', $solicitacao) }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-200">Nota (0 a 5)</label>
                            <input type="number" name="nota" min="0" max="5"
                                   class="mt-1 block w-full bg-gray-800 text-white border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-200">Comentário</label>
                            <textarea name="comentario"
                                      class="mt-1 block w-full bg-gray-800 text-white border-gray-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                        </div>

                        <button type="submit"
                                class="btn bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                            Enviar Avaliação
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
