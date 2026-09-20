<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Maintenance\Emplacement;
use App\Models\Maintenance\Site;
use Illuminate\Http\Request;

class EmplacementController extends Controller
{
    public function index()
    {
        $emplacements = Emplacement::with('site.client')->withCount('moteurs')->orderBy('name')->paginate(15);

        return view('maintenance.emplacements.index', compact('emplacements'));
    }

    public function create()
    {
        $sites = Site::with('client')->orderBy('name')->get();

        return view('maintenance.emplacements.create', compact('sites'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'maintenance_site_id' => 'required|exists:maintenance_sites,id',
            'name' => 'required|string|max:255',
            'atelier' => 'nullable|string|max:255',
        ]);

        Emplacement::create($data);

        return redirect()->route('maintenance.emplacements.index')->with('success', 'Emplacement créé.');
    }

    public function show(Emplacement $emplacement)
    {
        $emplacement->load(['site.client', 'moteurs']);

        return view('maintenance.emplacements.show', compact('emplacement'));
    }

    public function edit(Emplacement $emplacement)
    {
        $sites = Site::with('client')->orderBy('name')->get();

        return view('maintenance.emplacements.edit', compact('emplacement', 'sites'));
    }

    public function update(Request $request, Emplacement $emplacement)
    {
        $data = $request->validate([
            'maintenance_site_id' => 'required|exists:maintenance_sites,id',
            'name' => 'required|string|max:255',
            'atelier' => 'nullable|string|max:255',
        ]);

        $emplacement->update($data);

        return redirect()->route('maintenance.emplacements.index')->with('success', 'Emplacement mis à jour.');
    }

    public function destroy(Emplacement $emplacement)
    {
        $emplacement->delete();

        return redirect()->route('maintenance.emplacements.index')->with('success', 'Emplacement supprimé.');
    }
}
