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
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Mesure d\'isolement') }} — {{ $mesure->moteur->code_interne }}</h2>
            <a href="{{ route('maintenance.mesures.edit', $mesure) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Modifier') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $decisionClasses[$mesure->decision] }}">
                    {{ \App\Models\Maintenance\MesureIsolement::DECISION_LABELS[$mesure->decision] }}
                </span>
                <span class="text-sm text-gray-500">{{ $mesure->date->format('d/m/Y H:i') }}</span>
            </div>

            @if ($mesure->instrument && ! $mesure->instrument->estValide())
                <div class="bg-red-50 text-red-800 text-sm rounded-md px-4 py-3">
                    {{ __('Instrument périmé au moment de la mesure') }} ({{ $mesure->instrument->numero_serie }}).
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4">{{ __('Contexte') }}</h3>
                <dl class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('État thermique') }}</dt><dd>{{ $mesure->etat_thermique }}</dd></div>
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('Instrument') }}</dt><dd>{{ $mesure->instrument->numero_serie ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('Temp. ambiante') }}</dt><dd>{{ $mesure->temperature_ambiante ?? '—' }} °C</dd></div>
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('Humidité') }}</dt><dd>{{ $mesure->humidite ?? '—' }} %</dd></div>
                </dl>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4">{{ __('Essai') }}</h3>
                <dl class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('Circuit') }}</dt><dd>{{ str_replace('_', ' ', $mesure->circuit) }}</dd></div>
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('Tension d\'essai') }}</dt><dd>{{ $mesure->tension_essai_v }} V</dd></div>
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('Durée') }}</dt><dd>{{ $mesure->duree_essai_s ?? '—' }} s</dd></div>
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('Procédure') }}</dt><dd>{{ $mesure->procedure_utilisee ?? '—' }}</dd></div>
                </dl>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4">{{ __('Résultats & analyse') }}</h3>
                <dl class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('R 30s') }}</dt><dd>{{ $mesure->r_30s_mohm ?? '—' }} MΩ</dd></div>
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('R 60s') }}</dt><dd>{{ $mesure->r_60s_mohm ?? '—' }} MΩ</dd></div>
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('R 10min') }}</dt><dd>{{ $mesure->r_10min_mohm ?? '—' }} MΩ</dd></div>
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('Seuil applicable') }}</dt><dd>{{ $mesure->seuil_applicable_mohm ?? '—' }} MΩ</dd></div>
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('DAR') }}</dt><dd>{{ $mesure->dar ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-gray-500 uppercase">{{ __('PI') }}</dt><dd>{{ $mesure->pi ?? '—' }}</dd></div>
                </dl>
                @if ($mesure->observation)
                    <p class="mt-4 text-sm text-gray-600 border-t border-gray-100 pt-4">{{ $mesure->observation }}</p>
                @endif
            </div>

            <a href="{{ route('maintenance.moteurs.show', $mesure->moteur) }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; {{ __('Retour à la fiche moteur') }}</a>
        </div>
    </div>
</x-app-layout>
