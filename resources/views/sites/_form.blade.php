@php $site = $site ?? null; @endphp

<div>
    <x-input-label for="name" :value="__('Nom')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $site->name ?? '') }}" required autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-input-label for="address" :value="__('Adresse')" />
    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" value="{{ old('address', $site->address ?? '') }}" />
    <x-input-error :messages="$errors->get('address')" class="mt-2" />
</div>

<div>
    <x-input-label for="city" :value="__('Ville')" />
    <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" value="{{ old('city', $site->city ?? '') }}" />
    <x-input-error :messages="$errors->get('city')" class="mt-2" />
</div>
