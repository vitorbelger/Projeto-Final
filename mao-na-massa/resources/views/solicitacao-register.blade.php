<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ Auth::user()->role === 'trabalhador' ? __('Dashboard do Trabalhador') : __('Dashboard do Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="font-semibold text-lg">Registro de Solicitações</h2>

                    @if ($solicitacoes->isEmpty())
                        <p>Não há solicitações no momento.</p>
                    @else
                        <ul class="space-y-2">
                            @foreach ($solicitacoes as $solicitacao)
                                <li class="flex justify-between items-center border-b pb-2">
                                    <div>
                                        <a href="#" class="text-blue-500 hover:underline">
                                            Solicitação #{{ $solicitacao->id }} - Status:
                                            {{ ucfirst($solicitacao->status) }}
                                        </a>
                                        @if ($solicitacao->data_finalizacao)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Finalizada em: {{ $solicitacao->data_finalizacao->format('d/m/Y H:i') }}
                                            </p>
                                        @endif
                                    </div>

                                    @if (Auth::user()->role === 'trabalhador')
                                        @if ($solicitacao->status === 'pendente')
                                            <!-- Formulários de Aceitação ou Recusa -->
                                            <div>
                                                <form action="{{ route('solicitacoes.atualizar', $solicitacao) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="aceita">
                                                    <button type="submit" class="text-green-600 hover:underline">Aceitar</button>
                                                </form>

                                                <form action="{{ route('solicitacoes.atualizar', $solicitacao) }}" method="POST" class="inline-block ml-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejeitada">
                                                    <button type="submit" class="text-red-600 hover:underline">Recusar</button>
                                                </form>
                                            </div>
                                        @elseif ($solicitacao->status === 'aceita')
                                            <!-- Formulário de Finalização -->
                                            <form action="{{ route('solicitacoes.finalizar', $solicitacao) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-blue-600 hover:underline">Finalizar</button>
                                            </form>
                                        @endif
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
