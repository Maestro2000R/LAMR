<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Modifier la position') }} — {{ $moteur->code_interne }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('maintenance.positions.update', $position) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    @include('maintenance.moteurs.positions._form')
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>
                        <a href="{{ route('maintenance.moteurs.show', $moteur) }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Annuler') }}</a>
                    </div>
                </form>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-gray-800">{{ __('Historique des relevés') }}</h3>
                    <a href="{{ route('maintenance.positions.releves.create', $position) }}" class="text-sm text-indigo-600 hover:text-indigo-900">{{ __('Nouveau relevé') }} +</a>
                </div>
                @forelse ($position->releves as $releve)
                    <div class="flex justify-between items-center py-2 border-t border-gray-100 first:border-t-0 text-sm">
                        <span>{{ $releve->date->format('d/m/Y H:i') }} — {{ $releve->longueur_mesuree_mm }} mm ({{ $releve->etat_surface }})</span>
                        <form action="{{ route('maintenance.releves.destroy', $releve) }}" method="POST" onsubmit="return confirm('Supprimer ce relevé ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Supprimer') }}</button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">{{ __('Aucun relevé pour cette position.') }}</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
