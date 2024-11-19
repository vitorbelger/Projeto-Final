<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Trabalhador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('Olá, bem-vindo ao painel do trabalhador!') }}
                </div>
            </div>

            <div class="mt-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Solicitações Pendentes</h1>

                @if ($solicitacoes->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400 mt-4">Não há solicitações pendentes no momento.</p>
                @else
                    <table class="w-full mt-4 border-collapse border border-gray-300 dark:border-gray-700">
                        <thead>
                            <tr>
                                <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Descrição</th>
                                <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Data de Início</th>
                                <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Status</th>
                                <th class="border border-gray-300 dark:border-gray-700 px-4 py-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($solicitacoes as $solicitacao)
                                @if ($solicitacao->status === 'pendente')
                                    <!-- Exibe apenas as pendentes -->
                                    <tr>
                                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                            {{ $solicitacao->descricao }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                            {{ $solicitacao->data_inicio->format('d/m/Y') }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                            {{ ucfirst($solicitacao->status) }}
                                        </td>
                                        <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                                            <!-- Ações para aceitar ou recusar -->
                                            <form action="{{ route('solicitacoes.atualizar', $solicitacao) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="aceita">
                                                <button type="submit"
                                                    class="btn btn-success bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                                                    Aceitar
                                                </button>
                                            </form>
                                            <form action="{{ route('solicitacoes.atualizar', $solicitacao) }}"
                                                method="POST" class="inline-block ml-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejeitada">
                                                <button type="submit"
                                                    class="btn btn-danger bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                                                    Recusar
                                                </button>
                                            </form>
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
</x-app-layout>
