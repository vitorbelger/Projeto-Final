<div>
    <x-input-label for="profissao" :value="__('Profissão')" />
    <x-text-input id="profissao" class="block mt-1 w-full" type="text" name="profissao" :value="old('profissao')" autofocus
        autocomplete="profissao" />
    <x-input-error :messages="$errors->get('profissao')" class="mt-2" />
</div>
<div class="mt-4">
    <x-input-label for="curriculo" :value="__('Currículo')" />
    <textarea id="curriculo" name="curriculo"
        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        rows="4">{{ old('curriculo') }}</textarea>
    <x-input-error :messages="$errors->get('curriculo')" class="mt-2" />
</div>
