<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use App\Models\Maintenance\Instrument;
use Illuminate\Http\Request;

class InstrumentController extends Controller
{
    public function index()
    {
        $instruments = Instrument::orderBy('numero_serie')->paginate(15);

        return view('maintenance.instruments.index', compact('instruments'));
    }

    public function create()
    {
        return view('maintenance.instruments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'marque' => 'nullable|string|max:255',
            'modele' => 'nullable|string|max:255',
            'numero_serie' => 'required|string|max:255|unique:maintenance_instruments,numero_serie',
            'date_etalonnage' => 'nullable|date',
            'date_expiration' => 'nullable|date',
        ]);

        Instrument::create($data);

        return redirect()->route('maintenance.instruments.index')->with('success', 'Instrument créé.');
    }

    public function edit(Instrument $instrument)
    {
        return view('maintenance.instruments.edit', compact('instrument'));
    }

    public function update(Request $request, Instrument $instrument)
    {
        $data = $request->validate([
            'type' => 'required|string|max:255',
            'marque' => 'nullable|string|max:255',
            'modele' => 'nullable|string|max:255',
            'numero_serie' => 'required|string|max:255|unique:maintenance_instruments,numero_serie,'.$instrument->id,
            'date_etalonnage' => 'nullable|date',
            'date_expiration' => 'nullable|date',
        ]);

        $instrument->update($data);

        return redirect()->route('maintenance.instruments.index')->with('success', 'Instrument mis à jour.');
    }

    public function destroy(Instrument $instrument)
    {
        $instrument->delete();

        return redirect()->route('maintenance.instruments.index')->with('success', 'Instrument supprimé.');
    }
}
