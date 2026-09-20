@php $mesure = $mesure ?? null; @endphp

<fieldset class="border border-gray-200 rounded-md p-4">
    <legend class="text-sm font-medium text-gray-700 px-1">{{ __('Contexte') }}</legend>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <x-input-label for="date" :value="__('Date')" />
            <x-text-input id="date" name="date" type="datetime-local" class="mt-1 block w-full" value="{{ old('date', optional($mesure->date ?? now())->format('Y-m-d\TH:i')) }}" required />
            <x-input-error :messages="$errors->get('date')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="etat_thermique" :value="__('État thermique')" />
            @php $etat = old('etat_thermique', $mesure->etat_thermique ?? 'froid'); @endphp
            <select id="etat_thermique" name="etat_thermique" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="froid" @selected($etat === 'froid')>{{ __('Froid') }}</option>
                <option value="chaud" @selected($etat === 'chaud')>{{ __('Chaud') }}</option>
            </select>
        </div>
        <div>
            <x-input-label for="maintenance_instrument_id" :value="__('Instrument')" />
            <select id="maintenance_instrument_id" name="maintenance_instrument_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">{{ __('— Non renseigné —') }}</option>
                @foreach ($instruments as $instrument)
                    <option value="{{ $instrument->id }}" @selected(old('maintenance_instrument_id', $mesure->maintenance_instrument_id ?? '') == $instrument->id)>
                        {{ $instrument->numero_serie }} ({{ $instrument->marque }} {{ $instrument->modele }}){{ ! $instrument->estValide() ? ' — PÉRIMÉ' : '' }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('maintenance_instrument_id')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="duree_arret_h" :value="__('Durée d\'arrêt (h)')" />
            <x-text-input id="duree_arret_h" name="duree_arret_h" type="number" step="0.1" class="mt-1 block w-full" value="{{ old('duree_arret_h', $mesure->duree_arret_h ?? '') }}" />
        </div>
        <div>
            <x-input-label for="temperature_ambiante" :value="__('Température ambiante (°C)')" />
            <x-text-input id="temperature_ambiante" name="temperature_ambiante" type="number" step="0.1" class="mt-1 block w-full" value="{{ old('temperature_ambiante', $mesure->temperature_ambiante ?? '') }}" />
        </div>
        <div>
            <x-input-label for="temperature_enroulement" :value="__('Température enroulement (°C)')" />
            <x-text-input id="temperature_enroulement" name="temperature_enroulement" type="number" step="0.1" class="mt-1 block w-full" value="{{ old('temperature_enroulement', $mesure->temperature_enroulement ?? '') }}" />
        </div>
        <div>
            <x-input-label for="humidite" :value="__('Humidité (%)')" />
            <x-text-input id="humidite" name="humidite" type="number" step="0.1" class="mt-1 block w-full" value="{{ old('humidite', $mesure->humidite ?? '') }}" />
        </div>
        <div class="flex items-center mt-6">
            <label class="inline-flex items-center">
                <input type="hidden" name="nettoyage_prealable" value="0">
                <input type="checkbox" name="nettoyage_prealable" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" @checked(old('nettoyage_prealable', $mesure->nettoyage_prealable ?? false))>
                <span class="ms-2 text-sm text-gray-600">{{ __('Nettoyage préalable effectué') }}</span>
            </label>
        </div>
    </div>
</fieldset>

<fieldset class="border border-gray-200 rounded-md p-4">
    <legend class="text-sm font-medium text-gray-700 px-1">{{ __('Essai') }}</legend>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <x-input-label for="circuit" :value="__('Circuit testé')" />
            @php $circuit = old('circuit', $mesure->circuit ?? ''); @endphp
            <select id="circuit" name="circuit" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">{{ __('— Choisir —') }}</option>
                @foreach ([
                    'induit_masse' => 'Induit vers masse',
                    'excitation_shunt_masse' => 'Excitation shunt vers masse',
                    'excitation_serie_masse' => 'Excitation série vers masse',
                    'poles_auxiliaires_masse' => 'Pôles auxiliaires vers masse',
                    'entre_ensembles' => 'Entre ensembles',
                    'porte_balais_accessoires' => 'Porte-balais / accessoires',
                    'autre' => 'Autre',
                ] as $value => $label)
                    <option value="{{ $value }}" @selected($circuit === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('circuit')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="points_mesure" :value="__('Points de mesure')" />
            <x-text-input id="points_mesure" name="points_mesure" type="text" class="mt-1 block w-full" value="{{ old('points_mesure', $mesure->points_mesure ?? '') }}" />
        </div>
        <div>
            <x-input-label for="tension_essai_v" :value="__('Tension d\'essai (V DC)')" />
            <x-text-input id="tension_essai_v" name="tension_essai_v" type="number" class="mt-1 block w-full" value="{{ old('tension_essai_v', $mesure->tension_essai_v ?? 500) }}" required />
            <x-input-error :messages="$errors->get('tension_essai_v')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="duree_essai_s" :value="__('Durée d\'essai (s)')" />
            <x-text-input id="duree_essai_s" name="duree_essai_s" type="number" class="mt-1 block w-full" value="{{ old('duree_essai_s', $mesure->duree_essai_s ?? '') }}" />
        </div>
        <div>
            <x-input-label for="procedure_utilisee" :value="__('Procédure utilisée')" />
            <x-text-input id="procedure_utilisee" name="procedure_utilisee" type="text" class="mt-1 block w-full" value="{{ old('procedure_utilisee', $mesure->procedure_utilisee ?? '') }}" />
        </div>
        <div class="flex items-center mt-6">
            <label class="inline-flex items-center">
                <input type="hidden" name="decharge_apres_essai" value="0">
                <input type="checkbox" name="decharge_apres_essai" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" @checked(old('decharge_apres_essai', $mesure->decharge_apres_essai ?? true))>
                <span class="ms-2 text-sm text-gray-600">{{ __('Décharge effectuée après essai') }}</span>
            </label>
        </div>
    </div>
</fieldset>

<fieldset class="border border-gray-200 rounded-md p-4">
    <legend class="text-sm font-medium text-gray-700 px-1">{{ __('Résultats') }}</legend>
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div>
            <x-input-label for="unite_saisie" :value="__('Unité')" />
            @php $unite = old('unite_saisie', $mesure->unite_saisie ?? 'MOhm'); @endphp
            <select id="unite_saisie" name="unite_saisie" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="MOhm" @selected($unite === 'MOhm')>MΩ</option>
                <option value="GOhm" @selected($unite === 'GOhm')>GΩ</option>
            </select>
        </div>
        <div>
            <x-input-label for="r_30s_mohm" :value="__('R à 30 s')" />
            <x-text-input id="r_30s_mohm" name="r_30s_mohm" type="number" step="0.001" min="0" class="mt-1 block w-full" value="{{ old('r_30s_mohm', $mesure->r_30s_mohm ?? '') }}" />
            <x-input-error :messages="$errors->get('r_30s_mohm')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="r_60s_mohm" :value="__('R à 60 s')" />
            <x-text-input id="r_60s_mohm" name="r_60s_mohm" type="number" step="0.001" min="0" class="mt-1 block w-full" value="{{ old('r_60s_mohm', $mesure->r_60s_mohm ?? '') }}" />
            <x-input-error :messages="$errors->get('r_60s_mohm')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="r_10min_mohm" :value="__('R à 10 min (si applicable)')" />
            <x-text-input id="r_10min_mohm" name="r_10min_mohm" type="number" step="0.001" min="0" class="mt-1 block w-full" value="{{ old('r_10min_mohm', $mesure->r_10min_mohm ?? '') }}" />
            <x-input-error :messages="$errors->get('r_10min_mohm')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="courant_fuite" :value="__('Courant de fuite (mA)')" />
            <x-text-input id="courant_fuite" name="courant_fuite" type="number" step="0.001" min="0" class="mt-1 block w-full" value="{{ old('courant_fuite', $mesure->courant_fuite ?? '') }}" />
        </div>
        <div>
            <x-input-label for="seuil_applicable_mohm" :value="__('Seuil applicable (MΩ)')" />
            <x-text-input id="seuil_applicable_mohm" name="seuil_applicable_mohm" type="number" step="0.01" min="0" class="mt-1 block w-full" value="{{ old('seuil_applicable_mohm', $mesure->seuil_applicable_mohm ?? $moteur->seuil_isolement_mohm) }}" />
            <p class="mt-1 text-xs text-gray-500">{{ __('Pré-rempli depuis le seuil du moteur ; modifiable pour cet essai.') }}</p>
        </div>
    </div>
    <p class="mt-2 text-xs text-gray-500">DAR = R60s / R30s · PI = R10min / R60s — {{ __('calculés automatiquement à l\'enregistrement.') }}</p>
</fieldset>

<div>
    <x-input-label for="observation" :value="__('Observation')" />
    <textarea id="observation" name="observation" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('observation', $mesure->observation ?? '') }}</textarea>
</div>
