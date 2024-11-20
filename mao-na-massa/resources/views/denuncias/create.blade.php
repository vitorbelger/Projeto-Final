<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Denunciar Solicitação #{{ $solicitacao->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Detalhes da Solicitação</h3>

                    <p><strong>Denunciado:</strong>
                        {{ auth()->id() === $solicitacao->user_id ? $solicitacao->worker->user->name : $solicitacao->cliente->name }}
                    </p>

                    @if ($solicitacao->denuncia)
                        <p class="mt-4 text-yellow-500">Esta solicitação já foi denunciada.</p>
                    @else
                        <form method="POST" action="{{ route('denuncias.store', $solicitacao) }}" novalidate>
                            @csrf

                            {{-- Campo de Comentário --}}
                            <div class="mb-4">
                                <label for="comentario" class="block text-gray-200">Comentário</label>
                                <textarea id="comentario" name="comentario"
                                    class="mt-1 block w-full bg-gray-800 text-white border border-gray-600 @error('comentario') border-red-500 @enderror focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    required>{{ old('comentario') }}</textarea>
                                @error('comentario')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Botão de Enviar --}}
                            <button type="submit"
                                class="btn bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                                Enviar Denúncia
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
