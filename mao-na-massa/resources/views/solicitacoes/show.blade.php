<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalhes da Solicitação') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold">Solicitação de {{ $solicitacao->cliente->name }}</h3>
                    <p><strong>Descrição:</strong> {{ $solicitacao->descricao }}</p>
                    <p><strong>Data de Início:</strong> {{ $solicitacao->data_inicio }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($solicitacao->status) }}</p>

                    @if ($solicitacao->status === 'pendente')
                        <form action="{{ route('solicitacoes.concluir', $solicitacao->id) }}" method="POST"
                            class="mt-4">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label for="data_conclusao"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Data de Conclusão
                                </label>
                                <input type="date" id="data_conclusao" name="data_conclusao" required
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            </div>

                            <input type="hidden" name="status" value="aceita">

                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                                Aceitar Solicitação
                            </button>
                        </form>

                        <form action="{{ route('solicitacoes.concluir', $solicitacao->id) }}" method="POST"
                            class="mt-4">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="status" value="rejeitada">

                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                Recusar Solicitação
                            </button>
                        </form>
                    @else
                        <p>A solicitação já foi {{ $solicitacao->status }}.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
