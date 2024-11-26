<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Minhas Avaliações
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Avaliações Recebidas</h3>

                    {{-- Exibe o nome e a média do usuário --}}
                    <div class="mb-6">
                        <p class="text-lg font-semibold">{{ auth()->user()->name }}</p>
                        <p><strong>Média de Avaliação:</strong>
                           <span class="text-yellow-500">{{ number_format($media, 1) }} / 5</span>
                        </p>
                    </div>

                    @if ($avaliacoes->isEmpty())
                        <p class="text-center text-gray-500">Nenhuma avaliação recebida.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($avaliacoes as $avaliacao)
                                <li class="border-b border-gray-300 dark:border-gray-600 py-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p><strong>Avaliador:</strong> {{ $avaliacao->avaliador->name ?? 'Anônimo' }}</p>
                                            <p><strong>Nota:</strong> <span class="text-yellow-500">{{ $avaliacao->nota }}/5</span></p>
                                            <p><strong>Comentário:</strong> {{ $avaliacao->comentario ?? 'Sem comentário' }}</p>
                                            <p><strong>Data:</strong> {{ $avaliacao->created_at->format('d/m/Y') }}</p>
                                        </div>
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
