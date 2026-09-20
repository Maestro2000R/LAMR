<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $site->name }} <span class="text-gray-400 font-normal">— {{ $site->client->name }}</span></h2>
            <a href="{{ route('maintenance.sites.edit', $site) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Modifier') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Adresse') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $site->address ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Ville') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $site->city ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-800">{{ __('Emplacements') }}</h3>
                    <a href="{{ route('maintenance.emplacements.create') }}" class="text-sm text-indigo-600 hover:text-indigo-900">{{ __('Ajouter un emplacement') }} +</a>
                </div>
                @forelse ($site->emplacements as $emplacement)
                    <div class="flex justify-between items-center py-2 border-t border-gray-100 first:border-t-0 text-sm">
                        <a href="{{ route('maintenance.emplacements.show', $emplacement) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">{{ $emplacement->name }}</a>
                        <span class="text-gray-500">{{ $emplacement->atelier }}</span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">{{ __('Aucun emplacement pour ce site.') }}</p>
                @endforelse
            </div>

            <a href="{{ route('maintenance.sites.index') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; {{ __('Retour à la liste') }}</a>
        </div>
    </div>
</x-app-layout>
