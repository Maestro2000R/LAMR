<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Maintenance\Instrument;
use App\Models\Maintenance\MesureIsolement;
use App\Models\Maintenance\Moteur;
use App\Services\Maintenance\IsolationAnalyzer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MesureIsolementController extends Controller
{
    public function create(Moteur $moteur)
    {
        $instruments = Instrument::orderBy('numero_serie')->get();

        return view('maintenance.moteurs.mesures.create', compact('moteur', 'instruments'));
    }

    public function store(Request $request, Moteur $moteur, IsolationAnalyzer $analyzer)
    {
        $data = $request->validate($this->rules());

        $data = $this->normaliserUnites($data);

        $data['maintenance_moteur_id'] = $moteur->id;
        $data['user_id'] = $request->user()->id;
        $data['seuil_applicable_mohm'] = $data['seuil_applicable_mohm'] ?? $moteur->seuil_isolement_mohm;

        $analyse = $analyzer->analyser($data, $moteur);
        $data['dar'] = $analyse['dar'];
        $data['pi'] = $analyse['pi'];
        $data['decision'] = $analyse['decision'];

        $mesure = MesureIsolement::create($data);

        return redirect()->route('maintenance.moteurs.show', $moteur)
            ->with('success', 'Mesure d\'isolement enregistrée — classification : '.MesureIsolement::DECISION_LABELS[$mesure->decision]);
    }

    public function show(MesureIsolement $mesure)
    {
        $mesure->load(['moteur', 'instrument', 'user']);

        return view('maintenance.moteurs.mesures.show', compact('mesure'));
    }

    public function edit(MesureIsolement $mesure)
    {
        $mesure->load('moteur');
        $instruments = Instrument::orderBy('numero_serie')->get();

        return view('maintenance.moteurs.mesures.edit', ['mesure' => $mesure, 'moteur' => $mesure->moteur, 'instruments' => $instruments]);
    }

    public function update(Request $request, MesureIsolement $mesure, IsolationAnalyzer $analyzer)
    {
        $data = $request->validate($this->rules());
        $data = $this->normaliserUnites($data);
        $data['seuil_applicable_mohm'] = $data['seuil_applicable_mohm'] ?? $mesure->moteur->seuil_isolement_mohm;
        $data['exclude_id'] = $mesure->id;

        $analyse = $analyzer->analyser($data, $mesure->moteur);
        unset($data['exclude_id']);
        $data['dar'] = $analyse['dar'];
        $data['pi'] = $analyse['pi'];
        $data['decision'] = $analyse['decision'];

        $mesure->update($data);

        return redirect()->route('maintenance.moteurs.show', $mesure->moteur)->with('success', 'Mesure d\'isolement mise à jour.');
    }

    public function destroy(MesureIsolement $mesure)
    {
        $moteur = $mesure->moteur;
        $mesure->delete();

        return redirect()->route('maintenance.moteurs.show', $moteur)->with('success', 'Mesure d\'isolement supprimée.');
    }

    private function rules(): array
    {
        return [
            'maintenance_instrument_id' => 'nullable|exists:maintenance_instruments,id',
            'date' => 'required|date',
            'etat_thermique' => ['required', Rule::in(['chaud', 'froid'])],
            'duree_arret_h' => 'nullable|numeric|min:0',
            'temperature_ambiante' => 'nullable|numeric',
            'temperature_enroulement' => 'nullable|numeric',
            'humidite' => 'nullable|numeric|min:0|max:100',
            'nettoyage_prealable' => 'nullable|boolean',

            'circuit' => ['required', Rule::in([
                'induit_masse', 'excitation_shunt_masse', 'excitation_serie_masse',
                'poles_auxiliaires_masse', 'entre_ensembles', 'porte_balais_accessoires', 'autre',
            ])],
            'points_mesure' => 'nullable|string|max:255',
            'tension_essai_v' => 'required|integer|min:1',
            'duree_essai_s' => 'nullable|integer|min:0',
            'decharge_apres_essai' => 'nullable|boolean',
            'procedure_utilisee' => 'nullable|string|max:255',

            'unite_saisie' => ['required', Rule::in(['MOhm', 'GOhm'])],
            'r_30s_mohm' => 'nullable|numeric|min:0',
            'r_60s_mohm' => 'nullable|numeric|min:0',
            'r_10min_mohm' => 'nullable|numeric|min:0',
            'courant_fuite' => 'nullable|numeric|min:0',

            'seuil_applicable_mohm' => 'nullable|numeric|min:0',
            'observation' => 'nullable|string',
        ];
    }

    /**
     * Les mesures sont toujours saisies dans l'unité choisie par le technicien
     * mais stockées en MΩ, pour rester comparables (section 7.3 "Uniformité des unités").
     */
    private function normaliserUnites(array $data): array
    {
        if (($data['unite_saisie'] ?? 'MOhm') === 'GOhm') {
            foreach (['r_30s_mohm', 'r_60s_mohm', 'r_10min_mohm'] as $champ) {
                if (isset($data[$champ])) {
                    $data[$champ] = $data[$champ] * 1000;
                }
            }
        }

        return $data;
    }
}
