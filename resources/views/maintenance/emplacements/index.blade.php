<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Emplacements') }}</h2>
            <a href="{{ route('maintenance.emplacements.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                {{ __('Nouvel emplacement') }}
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Nom') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Atelier') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Site') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Client') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Moteurs') }}</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($emplacements as $emplacement)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('maintenance.emplacements.show', $emplacement) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">{{ $emplacement->name }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $emplacement->atelier ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $emplacement->site->name ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $emplacement->site->client->name ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $emplacement->moteurs_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-3">
                                        <a href="{{ route('maintenance.emplacements.edit', $emplacement) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Modifier') }}</a>
                                        <form action="{{ route('maintenance.emplacements.destroy', $emplacement) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cet emplacement ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">{{ __('Supprimer') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">{{ __('Aucun emplacement pour le moment.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($emplacements->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">{{ $emplacements->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
