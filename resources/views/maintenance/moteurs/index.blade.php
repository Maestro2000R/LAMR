<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Parc moteurs') }}</h2>
            <a href="{{ route('maintenance.moteurs.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Nouveau moteur') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <form method="GET" action="{{ route('maintenance.moteurs.index') }}" class="bg-white shadow-sm sm:rounded-lg p-4 flex flex-wrap items-end gap-4">
                <div>
                    <x-input-label for="q" :value="__('Recherche')" />
                    <x-text-input id="q" name="q" type="text" class="mt-1 w-64" value="{{ request('q') }}" placeholder="{{ __('Code, constructeur, modèle, n° série') }}" />
                </div>
                <div>
                    <x-input-label for="statut" :value="__('Statut')" />
                    <select id="statut" name="statut" class="mt-1 block w-48 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">{{ __('Tous') }}</option>
                        @foreach (\App\Models\Maintenance\Moteur::STATUT_LABELS as $value => $label)
                            <option value="{{ $value }}" @selected(request('statut') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <x-secondary-button type="submit">{{ __('Filtrer') }}</x-secondary-button>
                @if (request('q') || request('statut'))
                    <a href="{{ route('maintenance.moteurs.index') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Réinitialiser') }}</a>
                @endif
            </form>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Code') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Constructeur / modèle') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Emplacement') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Criticité') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Statut') }}</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($moteurs as $moteur)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('maintenance.moteurs.show', $moteur) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">{{ $moteur->code_interne }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $moteur->constructeur }} {{ $moteur->modele }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $moteur->emplacement->site->client->name ?? '—' }} — {{ $moteur->emplacement->site->name ?? '' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ \App\Models\Maintenance\Moteur::CRITICITE_LABELS[$moteur->classe_criticite] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            @class([
                                                'bg-green-100 text-green-800' => $moteur->statut === 'en_service',
                                                'bg-gray-100 text-gray-600' => in_array($moteur->statut, ['en_reserve', 'reforme']),
                                                'bg-amber-100 text-amber-800' => $moteur->statut === 'en_reparation',
                                                'bg-red-100 text-red-800' => $moteur->statut === 'indisponible',
                                            ])">
                                            {{ \App\Models\Maintenance\Moteur::STATUT_LABELS[$moteur->statut] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-3">
                                        <a href="{{ route('maintenance.moteurs.edit', $moteur) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Modifier') }}</a>
                                        <form action="{{ route('maintenance.moteurs.destroy', $moteur) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer ce moteur ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Supprimer') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">{{ __('Aucun moteur trouvé.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($moteurs->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">{{ $moteurs->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
