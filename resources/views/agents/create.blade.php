@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Créer un agent</h1>

    <form action="{{ route('agents.store') }}" method="POST">
        @csrf
        <div class="mb-2">
            <label class="block">Nom</label>
            <input name="name" class="border p-2 w-full" value="{{ old('name') }}">
        </div>
        <div class="mb-2">
            <label class="block">Email</label>
            <input name="email" class="border p-2 w-full" value="{{ old('email') }}">
        </div>
        <div class="mb-2">
            <label class="block">Téléphone</label>
            <input name="phone" class="border p-2 w-full" value="{{ old('phone') }}">
        </div>
        <div class="mb-2">
            <label class="block">Status</label>
            <select name="status" class="border p-2 w-full">
                <option value="active">active</option>
                <option value="inactive">inactive</option>
            </select>
        </div>
        <div>
            <button class="bg-blue-600 text-white px-3 py-1 rounded">Créer</button>
        </div>
    </form>
</div>
@endsection
