@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Créer une affectation</h1>
    <form action="{{ route('assignments.store') }}" method="POST">
        @csrf
        <div class="mb-2">
            <label class="block">Agent</label>
            <select name="agent_id" class="border p-2 w-full">
                @foreach(App\Models\Agent::all() as $agent)
                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label class="block">Site</label>
            <select name="site_id" class="border p-2 w-full">
                @foreach(App\Models\Site::all() as $site)
                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-2">
            <label class="block">Role</label>
            <input name="role" class="border p-2 w-full" value="{{ old('role') }}">
        </div>
        <div class="mb-2">
            <label class="block">Début</label>
            <input type="datetime-local" name="starts_at" class="border p-2 w-full" value="{{ old('starts_at') }}">
        </div>
        <div>
            <button class="bg-blue-600 text-white px-3 py-1 rounded">Créer</button>
        </div>
    </form>
</div>
@endsection
