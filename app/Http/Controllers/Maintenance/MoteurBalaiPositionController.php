<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Maintenance\Balai;
use App\Models\Maintenance\Moteur;
use App\Models\Maintenance\MoteurBalaiPosition;
use Illuminate\Http\Request;

class MoteurBalaiPositionController extends Controller
{
    public function create(Moteur $moteur)
    {
        $balais = Balai::orderBy('reference')->get();

        return view('maintenance.moteurs.positions.create', compact('moteur', 'balais'));
    }

    public function store(Request $request, Moteur $moteur)
    {
        $data = $request->validate([
            'maintenance_balai_id' => 'nullable|exists:maintenance_balais,id',
            'position' => 'required|string|max:255',
            'porte_balais' => 'nullable|string|max:255',
            'longueur_neuve_reference_mm' => 'required|numeric|min:0',
            'ordre' => 'nullable|integer|min:0',
        ]);

        $data['maintenance_moteur_id'] = $moteur->id;

        MoteurBalaiPosition::create($data);

        return redirect()->route('maintenance.moteurs.show', $moteur)->with('success', 'Position balai ajoutée.');
    }

    public function edit(MoteurBalaiPosition $position)
    {
        $position->load('moteur');
        $balais = Balai::orderBy('reference')->get();

        return view('maintenance.moteurs.positions.edit', ['position' => $position, 'moteur' => $position->moteur, 'balais' => $balais]);
    }

    public function update(Request $request, MoteurBalaiPosition $position)
    {
        $data = $request->validate([
            'maintenance_balai_id' => 'nullable|exists:maintenance_balais,id',
            'position' => 'required|string|max:255',
            'porte_balais' => 'nullable|string|max:255',
            'longueur_neuve_reference_mm' => 'required|numeric|min:0',
            'ordre' => 'nullable|integer|min:0',
        ]);

        $position->update($data);

        return redirect()->route('maintenance.moteurs.show', $position->maintenance_moteur_id)->with('success', 'Position balai mise à jour.');
    }

    public function destroy(MoteurBalaiPosition $position)
    {
        $moteurId = $position->maintenance_moteur_id;
        $position->delete();

        return redirect()->route('maintenance.moteurs.show', $moteurId)->with('success', 'Position balai supprimée.');
    }
}
