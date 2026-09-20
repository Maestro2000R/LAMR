@php $assignment = $assignment ?? null; @endphp

<div>
    <x-input-label for="agent_id" :value="__('Agent')" />
    <select id="agent_id" name="agent_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
        <option value="">{{ __('— Choisir un agent —') }}</option>
        @foreach ($agents as $agent)
            <option value="{{ $agent->id }}" @selected(old('agent_id', $assignment->agent_id ?? '') == $agent->id)>{{ $agent->name }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('agent_id')" class="mt-2" />
</div>

<div>
    <x-input-label for="site_id" :value="__('Site')" />
    <select id="site_id" name="site_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
        <option value="">{{ __('— Choisir un site —') }}</option>
        @foreach ($sites as $site)
            <option value="{{ $site->id }}" @selected(old('site_id', $assignment->site_id ?? '') == $site->id)>{{ $site->name }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('site_id')" class="mt-2" />
</div>

<div>
    <x-input-label for="role" :value="__('Rôle')" />
    <x-text-input id="role" name="role" type="text" class="mt-1 block w-full" value="{{ old('role', $assignment->role ?? '') }}" />
    <x-input-error :messages="$errors->get('role')" class="mt-2" />
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <x-input-label for="starts_at" :value="__('Début')" />
        <x-text-input id="starts_at" name="starts_at" type="datetime-local" class="mt-1 block w-full"
            value="{{ old('starts_at', optional($assignment->starts_at ?? null)->format('Y-m-d\TH:i')) }}" />
        <x-input-error :messages="$errors->get('starts_at')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="ends_at" :value="__('Fin')" />
        <x-text-input id="ends_at" name="ends_at" type="datetime-local" class="mt-1 block w-full"
            value="{{ old('ends_at', optional($assignment->ends_at ?? null)->format('Y-m-d\TH:i')) }}" />
        <x-input-error :messages="$errors->get('ends_at')" class="mt-2" />
    </div>
</div>
