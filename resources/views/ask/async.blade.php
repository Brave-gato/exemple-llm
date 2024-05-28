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
                    {{-- On ne doit pas mettre les attributs action et méthode --}}
                    <form class="space-y-4" id="form-ask">
                        {{-- pas besoin du champ csrf non plus --}}
                        <div>
                            <x-input-label for="question" :value="__('Votre question')" />
                            <x-text-input id="question" name="question" type="text" class="mt-1 block w-full"
                                :value="old('question')" autocomplete="question" />
                            <div id="question-errors"></div>
                        </div>
                        <div>
                            <x-input-label for="model" :value="__('Modèle')" />
                            <select id="model" name="model"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                @foreach ($models as $model)
                                    <option value="{{ $model['value']->value }}" @selected($default_model === $model['value']->value)>
                                        {{ $model['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Envoyer') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- cachée de base avec la classe hidden --}}
    <div id="answer-div" class="pb-12 hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        Réponse
                    </h2>
                    <div class="bg-gray-100 text-gray-900 p-6 prose max-w-none">
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // On attend que le DOM soit chargé
        document.addEventListener('DOMContentLoaded', function() {
            // On utilise le helper @json de Blade pour convertir la route en expression javascript valide
            const route = @json(route('async.ask'));
            const form = document.querySelector('#form-ask');


            // On écoute l'événement submit du formulaire
            form.addEventListener('submit', async function(event) {
                // On empêche le comportement par défaut du formulaire
                event.preventDefault();

                const questionErrors = document.querySelector('#question-errors');
                questionErrors.innerHTML = '';
                // On affiche la div de réponse et on change le texte
                document.querySelector('#answer-div').classList.remove('hidden');
                document.querySelector('.prose p').innerHTML =
                    "L'assistant est en train de répondre à votre question. Veuillez patienter."

                try {
                    // On envoie les données du formulaire en AJAX avec axios
                    const formData = new FormData(form);
                    const response = await axios.post(route, formData);
                    const data = response.data;

                    // On change le texte de la réponse et on vide le champ question
                    document.querySelector('.prose p').innerHTML = data.answer;
                    document.querySelector('#question').value = '';
                } catch (error) {
                    console.error(error);

                    // Si on a une erreur 422, on affiche les erreurs de validation
                    if (error.hasOwnProperty('response') && error.response.status === 422) {
                        const errors = error.response.data.errors;

                        document.querySelector('#answer-div').classList.add('hidden');

                        if (errors.question) {
                            errors.question.forEach(error => {
                                const p = document.createElement('p');
                                p.classList.add('text-sm', 'text-red-600', 'space-y-1', 'mt-2');
                                p.textContent = error;
                                questionErrors.appendChild(p);
                            });
                        }
                    }
                }
            });
        });
    </script>

</x-app-layout>
