@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <h1 class="text-xl font-bold mb-4">{{ $agent->name }}</h1>
    <p><strong>Email:</strong> {{ $agent->email }}</p>
    <p><strong>Téléphone:</strong> {{ $agent->phone }}</p>
    <p><strong>Status:</strong> {{ $agent->status }}</p>

    <h2 class="mt-4 font-bold">Affectations</h2>
    <ul>
        @foreach($agent->assignments as $a)
            <li>{{ $a->site->name ?? '—' }} — {{ $a->role }} ({{ $a->starts_at }} → {{ $a->ends_at }})</li>
        @endforeach
    </ul>
</div>
@endsection
