<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Maintenance\Client;
use App\Models\Maintenance\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::with('client')->withCount('emplacements')->orderBy('name')->paginate(15);

        return view('maintenance.sites.index', compact('sites'));
    }

    public function create()
    {
        $clients = Client::orderBy('name')->get();

        return view('maintenance.sites.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'maintenance_client_id' => 'required|exists:maintenance_clients,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
        ]);

        Site::create($data);

        return redirect()->route('maintenance.sites.index')->with('success', 'Site créé.');
    }

    public function show(Site $site)
    {
        $site->load(['client', 'emplacements']);

        return view('maintenance.sites.show', compact('site'));
    }

    public function edit(Site $site)
    {
        $clients = Client::orderBy('name')->get();

        return view('maintenance.sites.edit', compact('site', 'clients'));
    }

    public function update(Request $request, Site $site)
    {
        $data = $request->validate([
            'maintenance_client_id' => 'required|exists:maintenance_clients,id',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
        ]);

        $site->update($data);

        return redirect()->route('maintenance.sites.index')->with('success', 'Site mis à jour.');
    }

    public function destroy(Site $site)
    {
        $site->delete();

        return redirect()->route('maintenance.sites.index')->with('success', 'Site supprimé.');
    }
}
