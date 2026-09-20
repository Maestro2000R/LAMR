@php $emplacement = $emplacement ?? null; @endphp

<div>
    <x-input-label for="maintenance_site_id" :value="__('Site')" />
    <select id="maintenance_site_id" name="maintenance_site_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
        <option value="">{{ __('— Choisir un site —') }}</option>
        @foreach ($sites as $site)
            <option value="{{ $site->id }}" @selected(old('maintenance_site_id', $emplacement->maintenance_site_id ?? '') == $site->id)>{{ $site->client->name }} — {{ $site->name }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('maintenance_site_id')" class="mt-2" />
</div>

<div>
    <x-input-label for="name" :value="__('Nom de l\'emplacement')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $emplacement->name ?? '') }}" required />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-input-label for="atelier" :value="__('Atelier / ligne')" />
    <x-text-input id="atelier" name="atelier" type="text" class="mt-1 block w-full" value="{{ old('atelier', $emplacement->atelier ?? '') }}" />
    <x-input-error :messages="$errors->get('atelier')" class="mt-2" />
</div>
