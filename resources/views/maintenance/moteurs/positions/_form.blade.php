@php $position = $position ?? null; @endphp

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <x-input-label for="position" :value="__('Position')" />
        <x-text-input id="position" name="position" type="text" class="mt-1 block w-full" value="{{ old('position', $position->position ?? '') }}" required placeholder="{{ __('ex. Avant-Droit') }}" />
        <x-input-error :messages="$errors->get('position')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="porte_balais" :value="__('Porte-balais')" />
        <x-text-input id="porte_balais" name="porte_balais" type="text" class="mt-1 block w-full" value="{{ old('porte_balais', $position->porte_balais ?? '') }}" />
    </div>
    <div>
        <x-input-label for="maintenance_balai_id" :value="__('Référence balai')" />
        <select id="maintenance_balai_id" name="maintenance_balai_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            <option value="">{{ __('— Non référencé —') }}</option>
            @foreach ($balais as $balai)
                <option value="{{ $balai->id }}" @selected(old('maintenance_balai_id', $position->maintenance_balai_id ?? '') == $balai->id)>{{ $balai->reference }} ({{ $balai->fabricant }})</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('maintenance_balai_id')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="longueur_neuve_reference_mm" :value="__('Longueur neuve de référence (mm)')" />
        <x-text-input id="longueur_neuve_reference_mm" name="longueur_neuve_reference_mm" type="number" step="0.01" class="mt-1 block w-full" value="{{ old('longueur_neuve_reference_mm', $position->longueur_neuve_reference_mm ?? '') }}" required />
        <x-input-error :messages="$errors->get('longueur_neuve_reference_mm')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="ordre" :value="__('Ordre d\'affichage')" />
        <x-text-input id="ordre" name="ordre" type="number" class="mt-1 block w-full" value="{{ old('ordre', $position->ordre ?? 0) }}" />
    </div>
</div>
