@php $instrument = $instrument ?? null; @endphp

<div>
    <x-input-label for="type" :value="__('Type')" />
    <x-text-input id="type" name="type" type="text" class="mt-1 block w-full" value="{{ old('type', $instrument->type ?? 'megohmmetre') }}" required />
    <x-input-error :messages="$errors->get('type')" class="mt-2" />
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <x-input-label for="marque" :value="__('Marque')" />
        <x-text-input id="marque" name="marque" type="text" class="mt-1 block w-full" value="{{ old('marque', $instrument->marque ?? '') }}" />
        <x-input-error :messages="$errors->get('marque')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="modele" :value="__('Modèle')" />
        <x-text-input id="modele" name="modele" type="text" class="mt-1 block w-full" value="{{ old('modele', $instrument->modele ?? '') }}" />
        <x-input-error :messages="$errors->get('modele')" class="mt-2" />
    </div>
</div>

<div>
    <x-input-label for="numero_serie" :value="__('Numéro de série')" />
    <x-text-input id="numero_serie" name="numero_serie" type="text" class="mt-1 block w-full" value="{{ old('numero_serie', $instrument->numero_serie ?? '') }}" required />
    <x-input-error :messages="$errors->get('numero_serie')" class="mt-2" />
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <x-input-label for="date_etalonnage" :value="__('Date d\'étalonnage')" />
        <x-text-input id="date_etalonnage" name="date_etalonnage" type="date" class="mt-1 block w-full" value="{{ old('date_etalonnage', optional($instrument->date_etalonnage ?? null)->format('Y-m-d')) }}" />
        <x-input-error :messages="$errors->get('date_etalonnage')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="date_expiration" :value="__('Valide jusqu\'au')" />
        <x-text-input id="date_expiration" name="date_expiration" type="date" class="mt-1 block w-full" value="{{ old('date_expiration', optional($instrument->date_expiration ?? null)->format('Y-m-d')) }}" />
        <x-input-error :messages="$errors->get('date_expiration')" class="mt-2" />
    </div>
</div>
