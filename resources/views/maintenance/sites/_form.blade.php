@php $site = $site ?? null; @endphp

<div>
    <x-input-label for="maintenance_client_id" :value="__('Client')" />
    <select id="maintenance_client_id" name="maintenance_client_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
        <option value="">{{ __('— Choisir un client —') }}</option>
        @foreach ($clients as $client)
            <option value="{{ $client->id }}" @selected(old('maintenance_client_id', $site->maintenance_client_id ?? '') == $client->id)>{{ $client->name }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('maintenance_client_id')" class="mt-2" />
</div>

<div>
    <x-input-label for="name" :value="__('Nom du site')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $site->name ?? '') }}" required />
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
