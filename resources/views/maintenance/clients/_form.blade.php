@php $client = $client ?? null; @endphp

<div>
    <x-input-label for="name" :value="__('Nom')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $client->name ?? '') }}" required autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-input-label for="ice" :value="__('ICE')" />
    <x-text-input id="ice" name="ice" type="text" class="mt-1 block w-full" value="{{ old('ice', $client->ice ?? '') }}" />
    <x-input-error :messages="$errors->get('ice')" class="mt-2" />
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <x-input-label for="phone" :value="__('Téléphone')" />
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ old('phone', $client->phone ?? '') }}" />
        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $client->email ?? '') }}" />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
</div>
