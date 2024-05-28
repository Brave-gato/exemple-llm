<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Poser une question') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('ask') }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="mb-4">
                            <x-input-label for="question" :value="__('Votre question')" />
                            <x-text-input id="question" name="question" type="text" class="mt-1 block w-full"
                                :value="old('question')" autocomplete="question" />
                            <x-input-error class="mt-2" :messages="$errors->get('question')" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="model" :value="__('Modèle')" />
                            <select id="model" name="model"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach ($models as $model)
                                    <option value="{{ $model['value']->value }}" @selected($default_model === $model['value']->value)>
                                        {{ $model['name'] }}</option>
                                @endforeach
                            </select>

                            <x-input-error class="mt-2" :messages="$errors->get('model')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Envoyer') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if ($answer !== '')
        <div class="pb-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                            Réponse
                        </h2>
                        <div class="bg-gray-100 text-gray-900 p-6 prose max-w-none">
                            <p>{!! $answer !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
