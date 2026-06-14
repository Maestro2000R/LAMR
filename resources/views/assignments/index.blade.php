@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Affectations</h1>
        <a href="{{ route('assignments.create') }}" class="bg-blue-600 text-white px-3 py-1 rounded">Nouvelle affectation</a>
    </div>

    <ul>
        @foreach($assignments as $a)
            <li class="border-t py-2">
                <strong>{{ $a->agent->name ?? '—' }}</strong> → <em>{{ $a->site->name ?? '—' }}</em>
                <div class="text-sm text-gray-600">{{ $a->role }} — {{ $a->starts_at }} → {{ $a->ends_at }}</div>
            </li>
        @endforeach
    </ul>
</div>
@endsection
