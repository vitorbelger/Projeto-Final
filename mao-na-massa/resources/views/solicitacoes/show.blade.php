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
                    <h3 class="text-lg font-semibold">Telefone:  {{ $solicitacao->cliente->telefone }}</h3>
                    <h3 class="text-lg font-semibold">Endereço: {{ $solicitacao->cliente->endereco }}</h3>
                    <p><strong>Descrição:</strong> {{ $solicitacao->descricao }}</p>
                    <p><strong>Data de Início:</strong> {{ $solicitacao->data_inicio }}</p>
                    <p><strong>Data de Conclusão:</strong> {{ $solicitacao->data_conclusao }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($solicitacao->status) }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
