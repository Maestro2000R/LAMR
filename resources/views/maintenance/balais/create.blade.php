<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Nouvelle référence balai') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('maintenance.balais.store') }}" class="space-y-6">
                    @csrf
                    @include('maintenance.balais._form')
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Créer') }}</x-primary-button>
                        <a href="{{ route('maintenance.balais.index') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Annuler') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
