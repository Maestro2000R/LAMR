<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Instruments') }}</h2>
            <a href="{{ route('maintenance.instruments.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Nouvel instrument') }}
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('N° série') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Type') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Marque / modèle') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Validité') }}</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($instruments as $instrument)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $instrument->numero_serie }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $instrument->type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $instrument->marque }} {{ $instrument->modele }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($instrument->date_expiration)
                                            @if ($instrument->estValide())
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">{{ __('Valide jusqu\'au') }} {{ $instrument->date_expiration->format('d/m/Y') }}</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">{{ __('Périmé depuis le') }} {{ $instrument->date_expiration->format('d/m/Y') }}</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">{{ __('Non renseignée') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-3">
                                        <a href="{{ route('maintenance.instruments.edit', $instrument) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Modifier') }}</a>
                                        <form action="{{ route('maintenance.instruments.destroy', $instrument) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet instrument ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Supprimer') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">{{ __('Aucun instrument pour le moment.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($instruments->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">{{ $instruments->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
