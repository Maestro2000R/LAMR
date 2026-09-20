@php $balai = $balai ?? null; @endphp

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <x-input-label for="reference" :value="__('Référence')" />
        <x-text-input id="reference" name="reference" type="text" class="mt-1 block w-full" value="{{ old('reference', $balai->reference ?? '') }}" required autofocus />
        <x-input-error :messages="$errors->get('reference')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="fabricant" :value="__('Fabricant')" />
        <x-text-input id="fabricant" name="fabricant" type="text" class="mt-1 block w-full" value="{{ old('fabricant', $balai->fabricant ?? '') }}" />
        <x-input-error :messages="$errors->get('fabricant')" class="mt-2" />
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <x-input-label for="nuance_grade" :value="__('Nuance / grade')" />
        <x-text-input id="nuance_grade" name="nuance_grade" type="text" class="mt-1 block w-full" value="{{ old('nuance_grade', $balai->nuance_grade ?? '') }}" />
        <x-input-error :messages="$errors->get('nuance_grade')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="application" :value="__('Application / compatibilité')" />
        <x-text-input id="application" name="application" type="text" class="mt-1 block w-full" value="{{ old('application', $balai->application ?? '') }}" />
        <x-input-error :messages="$errors->get('application')" class="mt-2" />
    </div>
</div>

<fieldset class="border border-gray-200 rounded-md p-4">
    <legend class="text-sm font-medium text-gray-700 px-1">{{ __('Dimensions neuves (mm)') }}</legend>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <x-input-label for="longueur_neuve_mm" :value="__('Longueur')" />
            <x-text-input id="longueur_neuve_mm" name="longueur_neuve_mm" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('longueur_neuve_mm', $balai->longueur_neuve_mm ?? '') }}" required />
            <x-input-error :messages="$errors->get('longueur_neuve_mm')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="largeur_mm" :value="__('Largeur')" />
            <x-text-input id="largeur_mm" name="largeur_mm" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('largeur_mm', $balai->largeur_mm ?? '') }}" />
            <x-input-error :messages="$errors->get('largeur_mm')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="epaisseur_mm" :value="__('Épaisseur')" />
            <x-text-input id="epaisseur_mm" name="epaisseur_mm" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('epaisseur_mm', $balai->epaisseur_mm ?? '') }}" />
            <x-input-error :messages="$errors->get('epaisseur_mm')" class="mt-2" />
        </div>
    </div>
</fieldset>

<fieldset class="border border-gray-200 rounded-md p-4">
    <legend class="text-sm font-medium text-gray-700 px-1">{{ __('Limites') }}</legend>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <x-input-label for="longueur_min_mm" :value="__('Longueur minimale')" />
            <x-text-input id="longueur_min_mm" name="longueur_min_mm" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('longueur_min_mm', $balai->longueur_min_mm ?? '') }}" required />
            <x-input-error :messages="$errors->get('longueur_min_mm')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="seuil_alerte_mm" :value="__('Seuil d\'alerte')" />
            <x-text-input id="seuil_alerte_mm" name="seuil_alerte_mm" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('seuil_alerte_mm', $balai->seuil_alerte_mm ?? '') }}" />
            <x-input-error :messages="$errors->get('seuil_alerte_mm')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="tolerance_ecart_mm" :value="__('Tolérance d\'écart entre balais')" />
            <x-text-input id="tolerance_ecart_mm" name="tolerance_ecart_mm" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('tolerance_ecart_mm', $balai->tolerance_ecart_mm ?? '') }}" />
            <x-input-error :messages="$errors->get('tolerance_ecart_mm')" class="mt-2" />
        </div>
    </div>
</fieldset>

<fieldset class="border border-gray-200 rounded-md p-4">
    <legend class="text-sm font-medium text-gray-700 px-1">{{ __('Stock') }}</legend>
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div>
            <x-input-label for="quantite_stock" :value="__('Quantité')" />
            <x-text-input id="quantite_stock" name="quantite_stock" type="number" class="mt-1 block w-full" value="{{ old('quantite_stock', $balai->quantite_stock ?? 0) }}" required />
            <x-input-error :messages="$errors->get('quantite_stock')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="seuil_reappro" :value="__('Seuil réappro')" />
            <x-text-input id="seuil_reappro" name="seuil_reappro" type="number" class="mt-1 block w-full" value="{{ old('seuil_reappro', $balai->seuil_reappro ?? '') }}" />
            <x-input-error :messages="$errors->get('seuil_reappro')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="fournisseur" :value="__('Fournisseur')" />
            <x-text-input id="fournisseur" name="fournisseur" type="text" class="mt-1 block w-full" value="{{ old('fournisseur', $balai->fournisseur ?? '') }}" />
            <x-input-error :messages="$errors->get('fournisseur')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="delai_appro" :value="__('Délai')" />
            <x-text-input id="delai_appro" name="delai_appro" type="text" class="mt-1 block w-full" value="{{ old('delai_appro', $balai->delai_appro ?? '') }}" />
            <x-input-error :messages="$errors->get('delai_appro')" class="mt-2" />
        </div>
    </div>
</fieldset>
