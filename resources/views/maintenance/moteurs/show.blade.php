@php
    $decisionClasses = [
        'normal' => 'bg-green-100 text-green-800',
        'a_surveiller' => 'bg-amber-100 text-amber-800',
        'critique' => 'bg-red-100 text-red-800',
        'non_interpretable' => 'bg-gray-100 text-gray-600',
    ];
@endphp
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $moteur->code_interne }}</h2>
                <p class="text-sm text-gray-500">{{ $moteur->constructeur }} {{ $moteur->modele }} — {{ $moteur->emplacement->site->client->name }} / {{ $moteur->emplacement->site->name }} / {{ $moteur->emplacement->name }}</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-2 py-1 text-xs font-semibold rounded-full
                    @class([
                        'bg-green-100 text-green-800' => $moteur->statut === 'en_service',
                        'bg-gray-100 text-gray-600' => in_array($moteur->statut, ['en_reserve', 'reforme']),
                        'bg-amber-100 text-amber-800' => $moteur->statut === 'en_reparation',
                        'bg-red-100 text-red-800' => $moteur->statut === 'indisponible',
                    ])">
                    {{ \App\Models\Maintenance\Moteur::STATUT_LABELS[$moteur->statut] }}
                </span>
                <a href="{{ route('maintenance.moteurs.edit', $moteur) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    {{ __('Modifier') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Identité / plaque / construction / criticité --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-4">
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                        <div><dt class="text-xs font-medium text-gray-500 uppercase">{{ __('N° série') }}</dt><dd class="text-gray-900">{{ $moteur->numero_serie ?? '—' }}</dd></div>
                        <div><dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Année') }}</dt><dd class="text-gray-900">{{ $moteur->annee ?? '—' }}</dd></div>
                        <div><dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Puissance') }}</dt><dd class="text-gray-900">{{ $moteur->puissance_kw ? $moteur->puissance_kw.' kW' : '—' }}</dd></div>
                        <div><dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Tension') }}</dt><dd class="text-gray-900">{{ $moteur->tension_v ? $moteur->tension_v.' V' : '—' }}</dd></div>
                        <div><dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Courant') }}</dt><dd class="text-gray-900">{{ $moteur->courant_a ? $moteur->courant_a.' A' : '—' }}</dd></div>
                        <div><dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Vitesse') }}</dt><dd class="text-gray-900">{{ $moteur->vitesse_tr_min ? $moteur->vitesse_tr_min.' tr/min' : '—' }}</dd></div>
                        <div><dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Classe isolation') }}</dt><dd class="text-gray-900">{{ $moteur->classe_isolation ?? '—' }}</dd></div>
                        <div><dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Refroidissement') }}</dt><dd class="text-gray-900">{{ $moteur->type_refroidissement ?? '—' }}</dd></div>
                        <div><dt class="text-xs font-medium text-gray-500 uppercase">{{ __('Criticité') }}</dt><dd class="text-gray-900">{{ \App\Models\Maintenance\Moteur::CRITICITE_LABELS[$moteur->classe_criticite] }}</dd></div>
                    </div>
                    @if ($moteur->impact_securite || $moteur->redondance)
                        <div class="flex gap-2 text-xs">
                            @if ($moteur->impact_securite)
                                <span class="px-2 py-1 rounded-full bg-red-100 text-red-800">{{ __('Impact sécurité') }}</span>
                            @endif
                            @if ($moteur->redondance)
                                <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800">{{ __('Redondant') }}</span>
                            @endif
                        </div>
                    @endif
                    @if ($moteur->photo_moteur_path || $moteur->photo_plaque_path)
                        <div class="flex gap-4 pt-2">
                            @if ($moteur->photo_moteur_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($moteur->photo_moteur_path) }}" class="h-24 rounded border border-gray-200">
                            @endif
                            @if ($moteur->photo_plaque_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($moteur->photo_plaque_path) }}" class="h-24 rounded border border-gray-200">
                            @endif
                        </div>
                    @endif
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col items-center justify-center text-center">
                    <img src="{{ route('maintenance.moteurs.qr', $moteur) }}" alt="QR code" class="w-32 h-32">
                    <p class="mt-2 text-xs text-gray-500 break-all">{{ $moteur->qr_code }}</p>
                    <a href="{{ route('maintenance.moteurs.qr', $moteur) }}" target="_blank" class="mt-1 text-xs text-indigo-600 hover:text-indigo-900">{{ __('Ouvrir / imprimer') }}</a>
                </div>
            </div>

            {{-- Mesures d'isolement --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">{{ __('Mesures d\'isolement') }}</h3>
                    <a href="{{ route('maintenance.moteurs.mesures.create', $moteur) }}" class="text-sm text-indigo-600 hover:text-indigo-900">{{ __('Nouvelle campagne') }} +</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Circuit') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('R 60s (MΩ)') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('DAR') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('PI') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Classification') }}</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($moteur->mesuresIsolement as $mesure)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm"><a href="{{ route('maintenance.mesures.show', $mesure) }}" class="text-indigo-600 hover:text-indigo-900">{{ $mesure->date->format('d/m/Y H:i') }}</a></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ str_replace('_', ' ', $mesure->circuit) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $mesure->r_60s_mohm ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $mesure->dar ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $mesure->pi ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $decisionClasses[$mesure->decision] }}">
                                            {{ \App\Models\Maintenance\MesureIsolement::DECISION_LABELS[$mesure->decision] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <form action="{{ route('maintenance.mesures.destroy', $mesure) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette mesure ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Supprimer') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">{{ __('Aucune mesure d\'isolement enregistrée.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Balais --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-800">{{ __('Balais à charbon') }}</h3>
                    <a href="{{ route('maintenance.moteurs.positions.create', $moteur) }}" class="text-sm text-indigo-600 hover:text-indigo-900">{{ __('Ajouter une position') }} +</a>
                </div>

                @if ($desequilibre['ecart_mm'] !== null)
                    <div class="px-6 py-3 text-sm {{ $desequilibre['hors_tolerance'] ? 'bg-red-50 text-red-800' : 'bg-gray-50 text-gray-600' }}">
                        {{ __('Déséquilibre entre balais') }} : {{ $desequilibre['ecart_mm'] }} mm
                        @if ($desequilibre['tolerance_mm'] !== null)
                            ({{ __('tolérance') }} {{ $desequilibre['tolerance_mm'] }} mm)
                        @endif
                        @if ($desequilibre['hors_tolerance'])
                            — {{ __('hors tolérance') }}
                        @endif
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Position') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Référence') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Dernier relevé') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Usure') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Autonomie estimée') }}</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($moteur->balaiPositions as $position)
                                @php
                                    $dernier = $position->dernierReleve();
                                    $autonomie = $position->autonomieEstimee();
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $position->position }}
                                        @if ($position->porte_balais)<span class="text-gray-400">({{ $position->porte_balais }})</span>@endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $position->balai->reference ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        @if ($dernier)
                                            {{ $dernier->longueur_mesuree_mm }} mm — {{ $dernier->date->format('d/m/Y') }}
                                        @else
                                            {{ __('Aucun') }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        @if ($dernier && $dernier->pourcentageConsomme() !== null)
                                            {{ $dernier->pourcentageConsomme() }} %
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        @if ($autonomie['heures'] !== null)
                                            {{ round($autonomie['heures']) }} h
                                            <span class="text-xs text-gray-400">({{ $autonomie['fiabilite'] }})</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-3">
                                        <a href="{{ route('maintenance.positions.releves.create', $position) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Relever') }}</a>
                                        <a href="{{ route('maintenance.positions.edit', $position) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Modifier') }}</a>
                                        <form action="{{ route('maintenance.positions.destroy', $position) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette position ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Supprimer') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">{{ __('Aucune position de balai définie.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <a href="{{ route('maintenance.moteurs.index') }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; {{ __('Retour au parc moteurs') }}</a>
        </div>
    </div>
</x-app-layout>
