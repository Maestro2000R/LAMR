<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Relevé balai') }} — {{ $position->moteur->code_interne }} / {{ $position->position }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($position->balai)
                    <p class="text-sm text-gray-500 mb-4">
                        {{ __('Référence') }} {{ $position->balai->reference }} — {{ __('longueur neuve') }} {{ $position->longueur_neuve_reference_mm }} mm, {{ __('limite') }} {{ $position->balai->longueur_min_mm }} mm.
                    </p>
                @endif

                <form method="POST" action="{{ route('maintenance.positions.releves.store', $position) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" name="date" type="datetime-local" class="mt-1 block w-full" value="{{ old('date', now()->format('Y-m-d\TH:i')) }}" required />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="compteur_heures" :value="__('Compteur d\'heures')" />
                            <x-text-input id="compteur_heures" name="compteur_heures" type="number" class="mt-1 block w-full" value="{{ old('compteur_heures') }}" />
                        </div>
                        <div>
                            <x-input-label for="longueur_mesuree_mm" :value="__('Longueur mesurée (mm)')" />
                            <x-text-input id="longueur_mesuree_mm" name="longueur_mesuree_mm" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('longueur_mesuree_mm') }}" required />
                            <x-input-error :messages="$errors->get('longueur_mesuree_mm')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="etat_surface" :value="__('État de surface')" />
                            <select id="etat_surface" name="etat_surface" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @foreach ([
                                    'normal' => 'Normal', 'poli' => 'Poli', 'pique' => 'Piqué', 'brule' => 'Brûlé',
                                    'ebreche' => 'Ébréché', 'fissure' => 'Fissuré', 'usure_inclinee' => 'Usure inclinée', 'collage' => 'Collage',
                                ] as $value => $label)
                                    <option value="{{ $value }}" @selected(old('etat_surface') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="etat_tresse_cosse" :value="__('État tresse / cosse')" />
                            <x-text-input id="etat_tresse_cosse" name="etat_tresse_cosse" type="text" class="mt-1 block w-full" value="{{ old('etat_tresse_cosse') }}" />
                        </div>
                        <div>
                            <x-input-label for="echauffement_coloration" :value="__('Échauffement / coloration')" />
                            <x-text-input id="echauffement_coloration" name="echauffement_coloration" type="text" class="mt-1 block w-full" value="{{ old('echauffement_coloration') }}" />
                        </div>
                        <div class="flex items-center mt-6">
                            <label class="inline-flex items-center">
                                <input type="hidden" name="liberte_coulissement" value="0">
                                <input type="checkbox" name="liberte_coulissement" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" @checked(old('liberte_coulissement', true))>
                                <span class="ms-2 text-sm text-gray-600">{{ __('Coulisse librement') }}</span>
                            </label>
                        </div>
                        <div>
                            <x-input-label for="pression_ressort" :value="__('Pression du ressort')" />
                            <x-text-input id="pression_ressort" name="pression_ressort" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('pression_ressort') }}" />
                        </div>
                        <div>
                            <x-input-label for="pression_unite" :value="__('Unité pression')" />
                            <x-text-input id="pression_unite" name="pression_unite" type="text" class="mt-1 block w-full" value="{{ old('pression_unite') }}" placeholder="N" />
                        </div>
                        <div class="flex items-center mt-6">
                            <label class="inline-flex items-center">
                                <input type="hidden" name="pression_conforme" value="0">
                                <input type="checkbox" name="pression_conforme" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" @checked(old('pression_conforme'))>
                                <span class="ms-2 text-sm text-gray-600">{{ __('Pression conforme') }}</span>
                            </label>
                        </div>
                        <div>
                            <x-input-label for="action_realisee" :value="__('Action réalisée')" />
                            <select id="action_realisee" name="action_realisee" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="aucune" @selected(old('action_realisee', 'aucune') === 'aucune')>{{ __('Aucune') }}</option>
                                <option value="remplacement_individuel" @selected(old('action_realisee') === 'remplacement_individuel')>{{ __('Remplacement individuel') }}</option>
                                <option value="remplacement_jeu" @selected(old('action_realisee') === 'remplacement_jeu')>{{ __('Remplacement du jeu complet') }}</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="lot_monte" :value="__('Lot monté')" />
                            <x-text-input id="lot_monte" name="lot_monte" type="text" class="mt-1 block w-full" value="{{ old('lot_monte') }}" />
                        </div>
                        <div>
                            <x-input-label for="photo_avant" :value="__('Photo avant')" />
                            <input id="photo_avant" name="photo_avant" type="file" accept="image/*" class="mt-1 block w-full text-sm">
                        </div>
                        <div>
                            <x-input-label for="photo_apres" :value="__('Photo après')" />
                            <input id="photo_apres" name="photo_apres" type="file" accept="image/*" class="mt-1 block w-full text-sm">
                        </div>
                    </div>

                    <div>
                        <x-input-label for="observation" :value="__('Observation')" />
                        <textarea id="observation" name="observation" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('observation') }}</textarea>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Enregistrer le relevé') }}</x-primary-button>
                        <a href="{{ route('maintenance.moteurs.show', $position->maintenance_moteur_id) }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Annuler') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
