@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Agents</h1>
        <a href="{{ route('agents.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">Nouveau agent</a>
    </div>

    <table class="w-full table-auto">
        <thead>
        <tr class="text-left">
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Status</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($agents as $agent)
            <tr class="border-t">
                <td><a href="{{ route('agents.show', $agent) }}" class="text-blue-600">{{ $agent->name }}</a></td>
                <td>{{ $agent->email }}</td>
                <td>{{ $agent->phone }}</td>
                <td>{{ $agent->status }}</td>
                <td class="text-right">
                    <a href="{{ route('agents.edit', $agent) }}" class="text-indigo-600 mr-2">Modif</a>
                    <form action="{{ route('agents.destroy', $agent) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600" onclick="return confirm('Supprimer ?')">Suppr</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    
</div>
@endsection
