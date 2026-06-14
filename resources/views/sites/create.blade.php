@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Créer un site</h1>
    <form action="{{ route('sites.store') }}" method="POST">
        @csrf
        <div class="mb-2">
            <label class="block">Nom</label>
            <input name="name" class="border p-2 w-full" value="{{ old('name') }}">
        </div>
        <div class="mb-2">
            <label class="block">Adresse</label>
            <input name="address" class="border p-2 w-full" value="{{ old('address') }}">
        </div>
        <div class="mb-2">
            <label class="block">Ville</label>
            <input name="city" class="border p-2 w-full" value="{{ old('city') }}">
        </div>
        <div>
            <button class="bg-blue-600 text-white px-3 py-1 rounded">Créer</button>
        </div>
    </form>
</div>
@endsection
