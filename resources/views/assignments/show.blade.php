<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Affectation') }}</h2>
            <a href="{{ route('assignments.edit', $assignment) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Modifier') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Agent') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="{{ route('agents.show', $assignment->agent) }}" class="text-indigo-600 hover:text-indigo-900">{{ $assignment->agent->name ?? '—' }}</a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Site') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <a href="{{ route('sites.show', $assignment->site) }}" class="text-indigo-600 hover:text-indigo-900">{{ $assignment->site->name ?? '—' }}</a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Rôle') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $assignment->role ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Période') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ optional($assignment->starts_at)->format('d/m/Y H:i') ?? '—' }} → {{ optional($assignment->ends_at)->format('d/m/Y H:i') ?? __('en cours') }}
                        </dd>
                    </div>
                </dl>
            </div>

            <a href="{{ route('assignments.index') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; {{ __('Retour à la liste') }}</a>
        </div>
    </div>
</x-app-layout>
