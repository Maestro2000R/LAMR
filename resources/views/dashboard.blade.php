<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Tableau de bord') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Agents actifs') }}</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $activeAgentsCount }}</div>
                    <a href="{{ route('agents.index') }}" class="mt-2 inline-block text-sm text-indigo-600 hover:text-indigo-900">{{ __('Voir les agents') }} &rarr;</a>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Sites') }}</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $sitesCount }}</div>
                    <a href="{{ route('sites.index') }}" class="mt-2 inline-block text-sm text-indigo-600 hover:text-indigo-900">{{ __('Voir les sites') }} &rarr;</a>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('Affectations en cours') }}</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $ongoingAssignmentsCount }}</div>
                    <a href="{{ route('assignments.index') }}" class="mt-2 inline-block text-sm text-indigo-600 hover:text-indigo-900">{{ __('Voir les affectations') }} &rarr;</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">{{ __('Dernières affectations') }}</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Agent') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Site') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Rôle') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Début') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($recentAssignments as $assignment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('assignments.show', $assignment) }}" class="text-indigo-600 hover:text-indigo-900">{{ $assignment->agent->name ?? '—' }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $assignment->site->name ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $assignment->role ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ optional($assignment->starts_at)->format('d/m/Y') ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">{{ __('Aucune affectation pour le moment.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
