<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Maintenance\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::withCount('sites')->orderBy('name')->paginate(15);

        return view('maintenance.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('maintenance.clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'ice' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        Client::create($data);

        return redirect()->route('maintenance.clients.index')->with('success', 'Client créé.');
    }

    public function show(Client $client)
    {
        $client->load('sites');

        return view('maintenance.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('maintenance.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'ice' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        $client->update($data);

        return redirect()->route('maintenance.clients.index')->with('success', 'Client mis à jour.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('maintenance.clients.index')->with('success', 'Client supprimé.');
    }
}
