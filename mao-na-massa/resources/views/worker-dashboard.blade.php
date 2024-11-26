<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Trabalhador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Olá, bem-vindo ao painel do trabalhador!') }}
                </div>
            </div>

            <div class="mt-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Solicitações Pendentes</h1>

                @if ($solicitacoes->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400 mt-4">Não há solicitações pendentes no momento.</p>
                @else
                    <table class="w-full mt-4 border-collapse rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                <th class="px-4 py-2 text-left">Descrição</th>
                                <th class="px-4 py-2 text-left">Data de Início</th>
                                <th class="px-4 py-2 text-left">Data de Conclusão</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solicitacoes as $solicitacao)
                                @if ($solicitacao->status === 'pendente')
                                    <tr
                                        class="border-b border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800">
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                            {{ $solicitacao->descricao }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                            {{ $solicitacao->data_inicio->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                            {{ $solicitacao->data_conclusao->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                            {{ ucfirst($solicitacao->status) }}
                                        </td>
                                        <td class="px-4 py-2">
                                            <!-- Ações para aceitar ou recusar -->
                                            <form action="{{ route('solicitacoes.atualizar', $solicitacao) }}"
                                                method="POST" class="inline-block ml-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="aceita">
                                                <button type="submit"
                                                    class="bg-green-400 hover:bg-green-500 text-white px-4 py-2">
                                                    Aceitar
                                                </button>
                                            </form>
                                            <form action="{{ route('solicitacoes.atualizar', $solicitacao) }}"
                                                method="POST" class="inline-block ml-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejeitada">
                                                <button type="submit"
                                                    class="bg-red-400 hover:bg-red-500 text-white px-4 py-2">
                                                    Recusar
                                                </button>
                                            </form>
                                            <x-secondary-button x-data="{}"
                                                x-on:click.prevent="
                                                        $dispatch('open-modal', 'show-solicitation-details');
                                                        setTimeout(() => {
                                                        document.getElementById('solicitacao-descricao').innerText = '{{ $solicitacao->descricao }}';
                                                        document.getElementById('solicitacao-data-inicio').innerText = '{{ $solicitacao->data_inicio->format('d/m/Y') }}';
                                                        document.getElementById('solicitacao-data-conclusao').innerText = '{{ $solicitacao->data_conclusao->format('d/m/Y') }}';
                                                        document.getElementById('solicitacao-cliente').innerText = '{{ $solicitacao->cliente->name }}';
                                                        document.getElementById('solicitacao-telefone').innerText = '{{ $solicitacao->cliente->telefone ?? '--' }}';
                                                        document.getElementById('solicitacao-endereco').innerText = '{{ $solicitacao->cliente->endereco ?? '--' }}';
                                                        document.getElementById('solicitacao-media').innerText = '{{ number_format($solicitacao->cliente->mediaAvaliacoes() ?? 0, 1) }}';
                                                        }, 0);
                                                        ">
                                                {{ __('Ver Detalhes') }}
                                            </x-secondary-button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <x-modal name="show-solicitation-details" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Detalhes da Solicitação') }}
            </h2>

            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <strong>{{ __('Descrição:') }}</strong>
                <span id="solicitacao-descricao">--</span>
            </p>

            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <strong>{{ __('Data de Início:') }}</strong>
                <span id="solicitacao-data-inicio">--</span>
            </p>

            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <strong>{{ __('Data de Conclusão:') }}</strong>
                <span id="solicitacao-data-conclusao">--</span>
            </p>

            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <strong>{{ __('Cliente:') }}</strong>
                <span id="solicitacao-cliente">--</span>
            </p>

            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <strong>{{ __('Nota:') }}</strong>
                <span id="solicitacao-media" class="text-yellow-500"></span> / 5
            </p>

            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <strong>{{ __('Telefone:') }}</strong>
                <span id="solicitacao-telefone">--</span>
            </p>

            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <strong>{{ __('Endereço:') }}</strong>
                <span id="solicitacao-endereco">--</span>
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Fechar') }}
                </x-secondary-button>
            </div>
        </div>
    </x-modal>
</x-app-layout>
