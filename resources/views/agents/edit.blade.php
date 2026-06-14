@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Modifier un agent</h1>

    <form action="{{ route('agents.update', $agent) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-2">
            <label class="block">Nom</label>
            <input name="name" class="border p-2 w-full" value="{{ old('name', $agent->name) }}">
        </div>
        <div class="mb-2">
            <label class="block">Email</label>
            <input name="email" class="border p-2 w-full" value="{{ old('email', $agent->email) }}">
        </div>
        <div class="mb-2">
            <label class="block">Téléphone</label>
            <input name="phone" class="border p-2 w-full" value="{{ old('phone', $agent->phone) }}">
        </div>
        <div class="mb-2">
            <label class="block">Status</label>
            <select name="status" class="border p-2 w-full">
                <option value="active" {{ $agent->status === 'active' ? 'selected' : '' }}>active</option>
                <option value="inactive" {{ $agent->status === 'inactive' ? 'selected' : '' }}>inactive</option>
            </select>
        </div>
        <div>
            <button class="bg-blue-600 text-white px-3 py-1 rounded">Enregistrer</button>
        </div>
    </form>
</div>
@endsection
