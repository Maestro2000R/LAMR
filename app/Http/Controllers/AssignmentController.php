<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Assignment;
use App\Models\Site;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index(Request $request)
    {
        $assignments = Assignment::with(['agent', 'site'])
            ->when($request->filled('agent_id'), fn ($q) => $q->where('agent_id', $request->input('agent_id')))
            ->when($request->filled('site_id'), fn ($q) => $q->where('site_id', $request->input('site_id')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $agents = Agent::orderBy('name')->get();
        $sites = Site::orderBy('name')->get();

        return view('assignments.index', compact('assignments', 'agents', 'sites'));
    }

    public function create()
    {
        $agents = Agent::where('status', 'active')->orderBy('name')->get();
        $sites = Site::orderBy('name')->get();

        return view('assignments.create', compact('agents', 'sites'));
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

        return redirect()->route('assignments.index')->with('success', 'Affectation créée.');
    }

    public function show(Assignment $assignment)
    {
        $assignment->load(['agent', 'site']);
        return view('assignments.show', compact('assignment'));
    }

    public function edit(Assignment $assignment)
    {
        $agents = Agent::orderBy('name')->get();
        $sites = Site::orderBy('name')->get();

        return view('assignments.edit', compact('assignment', 'agents', 'sites'));
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

        return redirect()->route('assignments.index')->with('success', 'Affectation mise à jour.');
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();
        return redirect()->route('assignments.index')->with('success', 'Affectation supprimée.');
    }
}
