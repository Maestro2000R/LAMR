<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Maintenance\Balai;
use Illuminate\Http\Request;

class BalaiController extends Controller
{
    public function index()
    {
        $balais = Balai::orderBy('reference')->paginate(15);

        return view('maintenance.balais.index', compact('balais'));
    }

    public function create()
    {
        return view('maintenance.balais.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());

        Balai::create($data);

        return redirect()->route('maintenance.balais.index')->with('success', 'Référence balai créée.');
    }

    public function edit(Balai $balai)
    {
        return view('maintenance.balais.edit', compact('balai'));
    }

    public function update(Request $request, Balai $balai)
    {
        $data = $request->validate($this->rules($balai->id));

        $balai->update($data);

        return redirect()->route('maintenance.balais.index')->with('success', 'Référence balai mise à jour.');
    }

    public function destroy(Balai $balai)
    {
        $balai->delete();

        return redirect()->route('maintenance.balais.index')->with('success', 'Référence balai supprimée.');
    }

    private function rules(?int $ignoreId = null): array
    {
        return [
            'reference' => 'required|string|max:255|unique:maintenance_balais,reference,'.$ignoreId,
            'fabricant' => 'nullable|string|max:255',
            'nuance_grade' => 'nullable|string|max:255',
            'application' => 'nullable|string|max:255',
            'longueur_neuve_mm' => 'required|numeric|min:0',
            'largeur_mm' => 'nullable|numeric|min:0',
            'epaisseur_mm' => 'nullable|numeric|min:0',
            'longueur_min_mm' => 'required|numeric|min:0|lt:longueur_neuve_mm',
            'seuil_alerte_mm' => 'nullable|numeric|min:0',
            'tolerance_ecart_mm' => 'nullable|numeric|min:0',
            'quantite_stock' => 'required|integer|min:0',
            'seuil_reappro' => 'nullable|integer|min:0',
            'fournisseur' => 'nullable|string|max:255',
            'delai_appro' => 'nullable|string|max:255',
        ];
    }
}
