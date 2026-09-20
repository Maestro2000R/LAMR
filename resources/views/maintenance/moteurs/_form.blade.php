@php $moteur = $moteur ?? null; @endphp

<fieldset class="border border-gray-200 rounded-md p-4">
    <legend class="text-sm font-medium text-gray-700 px-1">{{ __('Identité') }}</legend>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="code_interne" :value="__('Code interne')" />
            <x-text-input id="code_interne" name="code_interne" type="text" class="mt-1 block w-full" value="{{ old('code_interne', $moteur->code_interne ?? '') }}" required autofocus />
            <x-input-error :messages="$errors->get('code_interne')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="maintenance_emplacement_id" :value="__('Emplacement')" />
            <select id="maintenance_emplacement_id" name="maintenance_emplacement_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="">{{ __('— Choisir —') }}</option>
                @foreach ($emplacements as $emplacement)
                    <option value="{{ $emplacement->id }}" @selected(old('maintenance_emplacement_id', $moteur->maintenance_emplacement_id ?? '') == $emplacement->id)>
                        {{ $emplacement->site->client->name }} — {{ $emplacement->site->name }} — {{ $emplacement->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('maintenance_emplacement_id')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="ligne" :value="__('Ligne')" />
            <x-text-input id="ligne" name="ligne" type="text" class="mt-1 block w-full" value="{{ old('ligne', $moteur->ligne ?? '') }}" />
        </div>
        <div>
            <x-input-label for="machine_entrainee" :value="__('Machine entraînée')" />
            <x-text-input id="machine_entrainee" name="machine_entrainee" type="text" class="mt-1 block w-full" value="{{ old('machine_entrainee', $moteur->machine_entrainee ?? '') }}" />
        </div>
        <div>
            <x-input-label for="repere_fonctionnel" :value="__('Repère fonctionnel')" />
            <x-text-input id="repere_fonctionnel" name="repere_fonctionnel" type="text" class="mt-1 block w-full" value="{{ old('repere_fonctionnel', $moteur->repere_fonctionnel ?? '') }}" />
        </div>
        <div>
            <x-input-label for="statut" :value="__('Statut')" />
            @php $statut = old('statut', $moteur->statut ?? 'en_service'); @endphp
            <select id="statut" name="statut" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                @foreach (\App\Models\Maintenance\Moteur::STATUT_LABELS as $value => $label)
                    <option value="{{ $value }}" @selected($statut === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
    </div>
</fieldset>

<fieldset class="border border-gray-200 rounded-md p-4">
    <legend class="text-sm font-medium text-gray-700 px-1">{{ __('Plaque signalétique') }}</legend>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <x-input-label for="constructeur" :value="__('Constructeur')" />
            <x-text-input id="constructeur" name="constructeur" type="text" class="mt-1 block w-full" value="{{ old('constructeur', $moteur->constructeur ?? '') }}" />
        </div>
        <div>
            <x-input-label for="modele" :value="__('Modèle')" />
            <x-text-input id="modele" name="modele" type="text" class="mt-1 block w-full" value="{{ old('modele', $moteur->modele ?? '') }}" />
        </div>
        <div>
            <x-input-label for="numero_serie" :value="__('Numéro de série')" />
            <x-text-input id="numero_serie" name="numero_serie" type="text" class="mt-1 block w-full" value="{{ old('numero_serie', $moteur->numero_serie ?? '') }}" />
        </div>
        <div>
            <x-input-label for="annee" :value="__('Année')" />
            <x-text-input id="annee" name="annee" type="number" class="mt-1 block w-full" value="{{ old('annee', $moteur->annee ?? '') }}" />
        </div>
        <div>
            <x-input-label for="puissance_kw" :value="__('Puissance (kW)')" />
            <x-text-input id="puissance_kw" name="puissance_kw" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('puissance_kw', $moteur->puissance_kw ?? '') }}" />
        </div>
        <div>
            <x-input-label for="tension_v" :value="__('Tension (V)')" />
            <x-text-input id="tension_v" name="tension_v" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('tension_v', $moteur->tension_v ?? '') }}" />
        </div>
        <div>
            <x-input-label for="courant_a" :value="__('Courant (A)')" />
            <x-text-input id="courant_a" name="courant_a" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('courant_a', $moteur->courant_a ?? '') }}" />
        </div>
        <div>
            <x-input-label for="vitesse_tr_min" :value="__('Vitesse (tr/min)')" />
            <x-text-input id="vitesse_tr_min" name="vitesse_tr_min" type="number" class="mt-1 block w-full" value="{{ old('vitesse_tr_min', $moteur->vitesse_tr_min ?? '') }}" />
        </div>
        <div>
            <x-input-label for="excitation" :value="__('Excitation')" />
            <x-text-input id="excitation" name="excitation" type="text" class="mt-1 block w-full" value="{{ old('excitation', $moteur->excitation ?? '') }}" />
        </div>
        <div>
            <x-input-label for="classe_isolation" :value="__('Classe d\'isolation')" />
            <x-text-input id="classe_isolation" name="classe_isolation" type="text" class="mt-1 block w-full" value="{{ old('classe_isolation', $moteur->classe_isolation ?? '') }}" />
        </div>
        <div>
            <x-input-label for="indice_ip" :value="__('Indice IP')" />
            <x-text-input id="indice_ip" name="indice_ip" type="text" class="mt-1 block w-full" value="{{ old('indice_ip', $moteur->indice_ip ?? '') }}" />
        </div>
        <div>
            <x-input-label for="service" :value="__('Service')" />
            <x-text-input id="service" name="service" type="text" class="mt-1 block w-full" value="{{ old('service', $moteur->service ?? '') }}" />
        </div>
    </div>
</fieldset>

<fieldset class="border border-gray-200 rounded-md p-4">
    <legend class="text-sm font-medium text-gray-700 px-1">{{ __('Construction') }}</legend>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <x-input-label for="type_refroidissement" :value="__('Type de refroidissement')" />
            <x-text-input id="type_refroidissement" name="type_refroidissement" type="text" class="mt-1 block w-full" value="{{ old('type_refroidissement', $moteur->type_refroidissement ?? '') }}" />
        </div>
        <div>
            <x-input-label for="nombre_poles" :value="__('Nombre de pôles')" />
            <x-text-input id="nombre_poles" name="nombre_poles" type="number" class="mt-1 block w-full" value="{{ old('nombre_poles', $moteur->nombre_poles ?? '') }}" />
        </div>
        <div>
            <x-input-label for="roulements" :value="__('Roulements')" />
            <x-text-input id="roulements" name="roulements" type="text" class="mt-1 block w-full" value="{{ old('roulements', $moteur->roulements ?? '') }}" />
        </div>
        <div>
            <x-input-label for="nombre_porte_balais" :value="__('Nombre de porte-balais')" />
            <x-text-input id="nombre_porte_balais" name="nombre_porte_balais" type="number" class="mt-1 block w-full" value="{{ old('nombre_porte_balais', $moteur->nombre_porte_balais ?? '') }}" />
        </div>
        <div>
            <x-input-label for="nombre_balais_par_porte_balais" :value="__('Balais par porte-balais')" />
            <x-text-input id="nombre_balais_par_porte_balais" name="nombre_balais_par_porte_balais" type="number" class="mt-1 block w-full" value="{{ old('nombre_balais_par_porte_balais', $moteur->nombre_balais_par_porte_balais ?? '') }}" />
        </div>
        <div class="flex items-center mt-6">
            <label class="inline-flex items-center">
                <input type="hidden" name="collecteur" value="0">
                <input type="checkbox" name="collecteur" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" @checked(old('collecteur', $moteur->collecteur ?? true))>
                <span class="ms-2 text-sm text-gray-600">{{ __('Équipé d\'un collecteur') }}</span>
            </label>
        </div>
    </div>
</fieldset>

<fieldset class="border border-gray-200 rounded-md p-4">
    <legend class="text-sm font-medium text-gray-700 px-1">{{ __('Criticité') }}</legend>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="classe_criticite" :value="__('Classe de criticité')" />
            @php $criticite = old('classe_criticite', $moteur->classe_criticite ?? 'moyenne'); @endphp
            <select id="classe_criticite" name="classe_criticite" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                @foreach (\App\Models\Maintenance\Moteur::CRITICITE_LABELS as $value => $label)
                    <option value="{{ $value }}" @selected($criticite === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <x-input-label for="delai_approvisionnement" :value="__('Délai d\'approvisionnement')" />
            <x-text-input id="delai_approvisionnement" name="delai_approvisionnement" type="text" class="mt-1 block w-full" value="{{ old('delai_approvisionnement', $moteur->delai_approvisionnement ?? '') }}" />
        </div>
        <div class="sm:col-span-2 flex gap-6">
            <label class="inline-flex items-center">
                <input type="hidden" name="impact_securite" value="0">
                <input type="checkbox" name="impact_securite" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" @checked(old('impact_securite', $moteur->impact_securite ?? false))>
                <span class="ms-2 text-sm text-gray-600">{{ __('Impact sécurité') }}</span>
            </label>
            <label class="inline-flex items-center">
                <input type="hidden" name="redondance" value="0">
                <input type="checkbox" name="redondance" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" @checked(old('redondance', $moteur->redondance ?? false))>
                <span class="ms-2 text-sm text-gray-600">{{ __('Redondance disponible') }}</span>
            </label>
        </div>
        <div>
            <x-input-label for="impact_production" :value="__('Impact production')" />
            <textarea id="impact_production" name="impact_production" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('impact_production', $moteur->impact_production ?? '') }}</textarea>
        </div>
        <div>
            <x-input-label for="impact_qualite" :value="__('Impact qualité')" />
            <textarea id="impact_qualite" name="impact_qualite" rows="2" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('impact_qualite', $moteur->impact_qualite ?? '') }}</textarea>
        </div>
    </div>
</fieldset>

<fieldset class="border border-gray-200 rounded-md p-4">
    <legend class="text-sm font-medium text-gray-700 px-1">{{ __('Seuil de contrôle') }}</legend>
    <div>
        <x-input-label for="seuil_isolement_mohm" :value="__('Seuil d\'isolement (MΩ)')" />
        <x-text-input id="seuil_isolement_mohm" name="seuil_isolement_mohm" type="number" step="0.01" class="mt-1 block w-full sm:w-64" value="{{ old('seuil_isolement_mohm', $moteur->seuil_isolement_mohm ?? '') }}" />
        <p class="mt-1 text-xs text-gray-500">{{ __('Utilisé par défaut pour classer les mesures d\'isolement de ce moteur.') }}</p>
    </div>
</fieldset>

<fieldset class="border border-gray-200 rounded-md p-4">
    <legend class="text-sm font-medium text-gray-700 px-1">{{ __('Documentation') }}</legend>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <x-input-label for="photo_plaque" :value="__('Photo de la plaque')" />
            <input id="photo_plaque" name="photo_plaque" type="file" accept="image/*" class="mt-1 block w-full text-sm">
            @if (isset($moteur) && $moteur->photo_plaque_path)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($moteur->photo_plaque_path) }}" class="mt-2 h-20 rounded border border-gray-200">
            @endif
            <x-input-error :messages="$errors->get('photo_plaque')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="photo_moteur" :value="__('Photo du moteur')" />
            <input id="photo_moteur" name="photo_moteur" type="file" accept="image/*" class="mt-1 block w-full text-sm">
            @if (isset($moteur) && $moteur->photo_moteur_path)
                <img src="{{ \Illuminate\Support\Facades\Storage::url($moteur->photo_moteur_path) }}" class="mt-2 h-20 rounded border border-gray-200">
            @endif
            <x-input-error :messages="$errors->get('photo_moteur')" class="mt-2" />
        </div>
    </div>
</fieldset>
