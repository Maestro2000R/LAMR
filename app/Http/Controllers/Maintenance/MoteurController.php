<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Maintenance\Emplacement;
use App\Models\Maintenance\Moteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MoteurController extends Controller
{
    public function index(Request $request)
    {
        $moteurs = Moteur::with('emplacement.site.client')
            ->when($request->filled('statut'), fn ($q) => $q->where('statut', $request->input('statut')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%'.$request->input('q').'%';
                $q->where(fn ($sub) => $sub->where('code_interne', 'like', $term)
                    ->orWhere('constructeur', 'like', $term)
                    ->orWhere('modele', 'like', $term)
                    ->orWhere('numero_serie', 'like', $term));
            })
            ->orderBy('code_interne')
            ->paginate(15)
            ->withQueryString();

        return view('maintenance.moteurs.index', compact('moteurs'));
    }

    public function create()
    {
        $emplacements = Emplacement::with('site.client')->orderBy('name')->get();

        return view('maintenance.moteurs.create', compact('emplacements'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        $data['qr_code'] = $data['qr_code'] ?? strtoupper(Str::random(10));

        if ($request->hasFile('photo_plaque')) {
            $data['photo_plaque_path'] = $request->file('photo_plaque')->store('moteurs/plaques', 'public');
        }
        if ($request->hasFile('photo_moteur')) {
            $data['photo_moteur_path'] = $request->file('photo_moteur')->store('moteurs/photos', 'public');
        }

        $moteur = Moteur::create($data);

        return redirect()->route('maintenance.moteurs.show', $moteur)->with('success', 'Moteur créé.');
    }

    public function show(Moteur $moteur)
    {
        $moteur->load([
            'emplacement.site.client',
            'mesuresIsolement.instrument',
            'balaiPositions.balai',
            'balaiPositions.releves',
        ]);

        $desequilibre = $moteur->desequilibreBalais();

        return view('maintenance.moteurs.show', compact('moteur', 'desequilibre'));
    }

    public function edit(Moteur $moteur)
    {
        $emplacements = Emplacement::with('site.client')->orderBy('name')->get();

        return view('maintenance.moteurs.edit', compact('moteur', 'emplacements'));
    }

    public function update(Request $request, Moteur $moteur)
    {
        $data = $request->validate($this->rules($moteur->id));

        if ($request->hasFile('photo_plaque')) {
            if ($moteur->photo_plaque_path) {
                Storage::disk('public')->delete($moteur->photo_plaque_path);
            }
            $data['photo_plaque_path'] = $request->file('photo_plaque')->store('moteurs/plaques', 'public');
        }
        if ($request->hasFile('photo_moteur')) {
            if ($moteur->photo_moteur_path) {
                Storage::disk('public')->delete($moteur->photo_moteur_path);
            }
            $data['photo_moteur_path'] = $request->file('photo_moteur')->store('moteurs/photos', 'public');
        }

        $moteur->update($data);

        return redirect()->route('maintenance.moteurs.show', $moteur)->with('success', 'Moteur mis à jour.');
    }

    public function destroy(Moteur $moteur)
    {
        $moteur->delete();

        return redirect()->route('maintenance.moteurs.index')->with('success', 'Moteur supprimé.');
    }

    public function qrCode(Moteur $moteur)
    {
        $svg = QrCode::format('svg')->size(240)->generate(route('maintenance.moteurs.show', $moteur));

        return response($svg)->header('Content-Type', 'image/svg+xml');
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'code_interne' => ['required', 'string', 'max:255', Rule::unique('maintenance_moteurs', 'code_interne')->ignore($ignoreId)],
            'qr_code' => ['nullable', 'string', 'max:255', Rule::unique('maintenance_moteurs', 'qr_code')->ignore($ignoreId)],
            'maintenance_emplacement_id' => 'required|exists:maintenance_emplacements,id',
            'ligne' => 'nullable|string|max:255',
            'machine_entrainee' => 'nullable|string|max:255',
            'repere_fonctionnel' => 'nullable|string|max:255',
            'statut' => ['required', Rule::in(array_keys(Moteur::STATUT_LABELS))],

            'constructeur' => 'nullable|string|max:255',
            'modele' => 'nullable|string|max:255',
            'numero_serie' => 'nullable|string|max:255',
            'annee' => 'nullable|integer|min:1900|max:'.(date('Y') + 1),
            'puissance_kw' => 'nullable|numeric|min:0',
            'tension_v' => 'nullable|numeric|min:0',
            'courant_a' => 'nullable|numeric|min:0',
            'vitesse_tr_min' => 'nullable|integer|min:0',
            'excitation' => 'nullable|string|max:255',
            'classe_isolation' => 'nullable|string|max:50',
            'indice_ip' => 'nullable|string|max:50',
            'service' => 'nullable|string|max:255',

            'type_refroidissement' => 'nullable|string|max:255',
            'nombre_poles' => 'nullable|integer|min:0',
            'roulements' => 'nullable|string|max:255',
            'collecteur' => 'nullable|boolean',
            'nombre_porte_balais' => 'nullable|integer|min:0',
            'nombre_balais_par_porte_balais' => 'nullable|integer|min:0',

            'classe_criticite' => ['required', Rule::in(array_keys(Moteur::CRITICITE_LABELS))],
            'impact_securite' => 'nullable|boolean',
            'impact_production' => 'nullable|string',
            'impact_qualite' => 'nullable|string',
            'redondance' => 'nullable|boolean',
            'delai_approvisionnement' => 'nullable|string|max:255',

            'photo_plaque' => 'nullable|image|max:5120',
            'photo_moteur' => 'nullable|image|max:5120',

            'seuil_isolement_mohm' => 'nullable|numeric|min:0',
        ];
    }
}
