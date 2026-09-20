@php $agent = $agent ?? null; @endphp

<div>
    <x-input-label for="name" :value="__('Nom')" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $agent->name ?? '') }}" required autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-input-label for="email" :value="__('Email')" />
    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $agent->email ?? '') }}" required />
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
</div>

<div>
    <x-input-label for="phone" :value="__('Téléphone')" />
    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" value="{{ old('phone', $agent->phone ?? '') }}" />
    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
</div>

<div>
    <x-input-label for="status" :value="__('Statut')" />
    @php $status = old('status', $agent->status ?? 'active'); @endphp
    <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
        <option value="active" @selected($status === 'active')>{{ __('active') }}</option>
        <option value="inactive" @selected($status === 'inactive')>{{ __('inactive') }}</option>
    </select>
    <x-input-error :messages="$errors->get('status')" class="mt-2" />
</div>
