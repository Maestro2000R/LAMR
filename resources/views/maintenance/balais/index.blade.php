<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Catalogue balais') }}</h2>
            <a href="{{ route('maintenance.balais.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Nouvelle référence') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Référence') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Fabricant') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Longueur neuve / min') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Stock') }}</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($balais as $balai)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $balai->reference }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $balai->fabricant ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $balai->longueur_neuve_mm }} / {{ $balai->longueur_min_mm }} mm</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($balai->stockSousSeuil())
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">{{ $balai->quantite_stock }} {{ __('(sous seuil)') }}</span>
                                        @else
                                            <span class="text-gray-600">{{ $balai->quantite_stock }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-3">
                                        <a href="{{ route('maintenance.balais.edit', $balai) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Modifier') }}</a>
                                        <form action="{{ route('maintenance.balais.destroy', $balai) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette référence ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Supprimer') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">{{ __('Aucune référence de balai pour le moment.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($balais->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">{{ $balais->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
