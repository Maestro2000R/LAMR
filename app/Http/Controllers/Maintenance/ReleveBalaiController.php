<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Maintenance\MoteurBalaiPosition;
use App\Models\Maintenance\ReleveBalai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ReleveBalaiController extends Controller
{
    public function create(MoteurBalaiPosition $position)
    {
        $position->load('moteur', 'balai');

        return view('maintenance.moteurs.releves.create', compact('position'));
    }

    public function store(Request $request, MoteurBalaiPosition $position)
    {
        $data = $request->validate($this->rules());

        $data['maintenance_moteur_balai_position_id'] = $position->id;
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('photo_avant')) {
            $data['photo_avant_path'] = $request->file('photo_avant')->store('balais/avant', 'public');
        }
        if ($request->hasFile('photo_apres')) {
            $data['photo_apres_path'] = $request->file('photo_apres')->store('balais/apres', 'public');
        }

        ReleveBalai::create($data);

        return redirect()->route('maintenance.moteurs.show', $position->maintenance_moteur_id)->with('success', 'Relevé balai enregistré.');
    }

    public function destroy(ReleveBalai $releve)
    {
        $moteurId = $releve->position->maintenance_moteur_id;
        $releve->delete();

        return redirect()->route('maintenance.moteurs.show', $moteurId)->with('success', 'Relevé balai supprimé.');
    }

    private function rules(): array
    {
        return [
            'date' => 'required|date',
            'compteur_heures' => 'nullable|integer|min:0',
            'longueur_mesuree_mm' => 'required|numeric|min:0',
            'etat_surface' => ['required', Rule::in([
                'normal', 'poli', 'pique', 'brule', 'ebreche', 'fissure', 'usure_inclinee', 'collage',
            ])],
            'liberte_coulissement' => 'nullable|boolean',
            'etat_tresse_cosse' => 'nullable|string|max:255',
            'echauffement_coloration' => 'nullable|string|max:255',
            'pression_ressort' => 'nullable|numeric|min:0',
            'pression_unite' => 'nullable|string|max:50',
            'pression_conforme' => 'nullable|boolean',
            'photo_avant' => 'nullable|image|max:5120',
            'photo_apres' => 'nullable|image|max:5120',
            'action_realisee' => ['required', Rule::in(['aucune', 'remplacement_individuel', 'remplacement_jeu'])],
            'lot_monte' => 'nullable|string|max:255',
            'observation' => 'nullable|string',
        ];
    }
}
