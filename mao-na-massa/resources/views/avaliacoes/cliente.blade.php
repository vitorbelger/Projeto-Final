<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Avaliar Trabalhadores
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Solicitações Finalizadas</h3>

                    @if ($solicitacoes->isEmpty())
                        <p class="text-center text-gray-500">Não há solicitações finalizadas para avaliar.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($solicitacoes as $solicitacao)
                                <li class="border-b border-gray-300 dark:border-gray-600 py-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <strong>Trabalhador:</strong>
                                            {{ $solicitacao->worker->user->name ?? 'N/A' }}<br>
                                            <strong>Data de Finalização:</strong>
                                            {{ $solicitacao->data_finalizacao ? $solicitacao->data_finalizacao->format('d/m/Y') : 'Data não disponível' }}
                                        </div>

                                        <a href="{{ route('avaliacoes.create', ['solicitacao' => $solicitacao->id]) }}"
                                            class="text-blue-500 hover:text-blue-700 transition duration-200">Avaliar</a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
