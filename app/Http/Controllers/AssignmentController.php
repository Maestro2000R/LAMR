<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with(['agent', 'site'])->get();
        return view('assignments.index', compact('assignments'));
    }

    public function create()
    {
        return view('assignments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'site_id' => 'required|exists:sites,id',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'role' => 'nullable|string|max:255',
        ]);

        Assignment::create($data);

        return redirect()->route('assignments.index')->with('success', 'Assignment créé.');
    }

    public function show(Assignment $assignment)
    {
        return view('assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        return view('assignments.edit', compact('assignment'));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $data = $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'site_id' => 'required|exists:sites,id',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'role' => 'nullable|string|max:255',
        ]);

        $assignment->update($data);

        return redirect()->route('assignments.index')->with('success', 'Assignment mis à jour.');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignments.index')->with('success', 'Assignment supprimé.');
    }
}
