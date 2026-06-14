@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Sites</h1>
        <a href="{{ route('sites.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">Nouveau site</a>
    </div>

    <ul>
        @foreach($sites as $site)
            <li class="border-t py-2 flex justify-between">
                <div>
                    <strong>{{ $site->name }}</strong><br>
                    <small>{{ $site->address }} — {{ $site->city }}</small>
                </div>
                <div>
                    <a href="{{ route('sites.edit', $site) }}" class="text-indigo-600 mr-2">Modif</a>
                    <form action="{{ route('sites.destroy', $site) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600" onclick="return confirm('Supprimer ?')">Suppr</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
