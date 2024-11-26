<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Auth::user()->role === 'trabalhador' ? __('Trabalhador') : __('Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-semibold text-lg mb-4">Registro de Solicitações</h2>

                    @if ($solicitacoes->isEmpty())
                        <p class="text-center text-gray-500">Não há solicitações no momento.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($solicitacoes as $solicitacao)
                                <li class="flex justify-between items-center border-b border-gray-300 dark:border-gray-600 py-4">
                                    <div>
                                        <button
                                            x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'details-modal-{{ $solicitacao->id }}')"
                                            class="text-blue-500 hover:underline"
                                        >
                                            Solicitação {{ $solicitacao->id }} - Status: {{ ucfirst($solicitacao->status) }}
                                        </button>
                                        @if ($solicitacao->data_finalizacao)
                                            <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                                                Finalizada em: {{ $solicitacao->data_finalizacao->format('d/m/Y') }}
                                            </p>
                                        @endif
                                    </div>

                                    @if (Auth::user()->role === 'trabalhador')
                                        @if ($solicitacao->status === 'pendente')
                                            <div class="flex items-center space-x-2">
                                                <form action="{{ route('solicitacoes.atualizar', $solicitacao) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="aceita">
                                                    <button type="submit" class="text-green-500 hover:text-green-700 transition duration-200">Aceitar</button>
                                                </form>
                                                <form action="{{ route('solicitacoes.atualizar', $solicitacao) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejeitada">
                                                    <button type="submit" class="text-red-500 hover:text-red-700 transition duration-200">Recusar</button>
                                                </form>
                                            </div>
                                        @elseif ($solicitacao->status === 'aceita')
                                            <form action="{{ route('solicitacoes.finalizar', $solicitacao) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-blue-500 hover:text-blue-700 transition duration-200">Finalizar</button>
                                            </form>
                                        @endif
                                    @endif
                                </li>

                                <!-- Modal de detalhes -->
                                <x-modal name="details-modal-{{ $solicitacao->id }}" focusable>
                                    <div class="p-6">
                                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Detalhes da Solicitação</h2>
                                        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                                            <strong>Descrição:</strong> {{ $solicitacao->descricao }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <strong>Data de Início:</strong> {{ $solicitacao->data_inicio->format('d/m/Y') }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <strong>Data de Conclusão:</strong> {{ $solicitacao->data_conclusao->format('d/m/Y') }}
                                        </p>

                                        @if (Auth::user()->role === 'trabalhador')
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                <strong>Cliente:</strong> {{ $solicitacao->cliente->name }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                <strong>Telefone:</strong> {{ $solicitacao->cliente->telefone }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                <strong>Endereço:</strong> {{ $solicitacao->cliente->endereco }}
                                            </p>
                                        @elseif (Auth::user()->role === 'cliente')
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                <strong>Trabalhador:</strong> {{ $solicitacao->worker->user->name }}
                                            </p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                <strong>Telefone:</strong> {{ $solicitacao->worker->user->telefone }}
                                            </p>
                                        @endif

                                        <div class="mt-6 flex justify-end">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                Fechar
                                            </x-secondary-button>
                                        </div>
                                    </div>
                                </x-modal>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
