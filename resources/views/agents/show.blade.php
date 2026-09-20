<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $agent->name }}</h2>
            <a href="{{ route('agents.edit', $agent) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Modifier') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Email') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $agent->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Téléphone') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $agent->phone ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Statut') }}</dt>
                        <dd class="mt-1 text-sm">
                            @if ($agent->status === 'active')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ __('active') }}</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">{{ __('inactive') }}</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4">{{ __('Affectations') }}</h3>
                @forelse ($agent->assignments as $assignment)
                    <div class="flex justify-between items-center py-2 border-t border-gray-100 first:border-t-0 text-sm">
                        <div>
                            <a href="{{ route('sites.show', $assignment->site) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">{{ $assignment->site->name ?? '—' }}</a>
                            <span class="text-gray-500">— {{ $assignment->role ?? __('Sans rôle') }}</span>
                        </div>
                        <div class="text-gray-500">
                            {{ optional($assignment->starts_at)->format('d/m/Y') ?? '—' }} → {{ optional($assignment->ends_at)->format('d/m/Y') ?? __('en cours') }}
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">{{ __('Aucune affectation pour cet agent.') }}</p>
                @endforelse
            </div>

            <a href="{{ route('agents.index') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; {{ __('Retour à la liste') }}</a>
        </div>
    </div>
</x-app-layout>
