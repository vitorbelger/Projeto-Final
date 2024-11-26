<section>
    <header class="mb-4">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informação do Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Atualize as Informações Pessoais da sua Conta.') }}
        </p>
    </header>

    <!-- Formulário de Verificação -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Formulário de Edição -->
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Nome -->
        <div>
            <x-input-label for="name" :value="__('Nome')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <!-- Mensagem para Email não Verificado -->
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="text-sm mt-4 text-gray-800 dark:text-gray-200">
                {{ __('Your email address is unverified.') }}
                <button form="send-verification"
                    class="underline text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    {{ __('Click here to re-send the verification email.') }}
                </button>
                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif

        <!-- CPF -->
        <div>
            <x-input-label for="cpf" :value="__('CPF')" />
            <x-text-input id="cpf" name="cpf" type="text" class="mt-1 block w-full" :value="old('cpf', $user->cpf)"
                required autocomplete="cpf" />
            <x-input-error class="mt-2" :messages="$errors->get('cpf')" />
        </div>

        <!-- Telefone -->
        <div>
            <x-input-label for="telefone" :value="__('Telefone')" />
            <x-text-input id="telefone" name="telefone" type="text" class="mt-1 block w-full" :value="old('telefone', $user->telefone)"
                autocomplete="telefone" />
            <x-input-error class="mt-2" :messages="$errors->get('telefone')" />
        </div>

        <!-- Endereço -->
        <div>
            <x-input-label for="endereco" :value="__('Endereço')" />
            <x-text-input id="endereco" name="endereco" type="text" class="mt-1 block w-full" :value="old('endereco', $user->endereco)"
                autocomplete="endereco" />
            <x-input-error class="mt-2" :messages="$errors->get('endereco')" />
        </div>


        <!-- Campos para Trabalhador -->
        @if ($user->role === 'trabalhador')
            <div>
                <x-input-label for="profissao" :value="__('Profissão')" />
                <x-text-input id="profissao" name="profissao" type="text" class="mt-1 block w-full"
                    :value="old('profissao', $user->worker->profissao ?? '')" autocomplete="profissao" />
                <x-input-error class="mt-2" :messages="$errors->get('profissao')" />
            </div>

            <div>
                <x-input-label for="curriculo" :value="__('Currículo')" />
                <textarea id="curriculo" name="curriculo"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-700
                    dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600
                    focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                    rows="4">
                    {{ old('curriculo', $user->worker->curriculo ?? '') }}
                </textarea>
                <x-input-error class="mt-2" :messages="$errors->get('curriculo')" />
            </div>
        @endif

        <!-- Campo de Confirmação de Senha -->
        <div>
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"
                placeholder="{{ __('Senha') }}" required />
            <x-input-error class="mt-2" :messages="$errors->get('password')" />
        </div>

        <!-- Botões -->
        <div class="flex items-center gap-4 mt-4">
            <x-primary-button>{{ __('Salvar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Salvo.') }}</p>
            @endif
        </div>
    </form>
</section>
