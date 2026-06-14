<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::all();
        return view('agents.index', compact('agents'));
    }

    public function create()
    {
        return view('agents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'phone' => 'nullable|string|max:50',
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        Agent::create($data);

        return redirect()->route('agents.index')->with('success', 'Agent créé.');
    }

    public function show(Agent $agent)
    {
        return view('agents.show', compact('agent'));
    }

    public function edit(Agent $agent)
    {
        return view('agents.edit', compact('agent'));
    }

    public function update(Request $request, Agent $agent)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('agents')->ignore($agent->id)],
            'phone' => 'nullable|string|max:50',
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $agent->update($data);

        return redirect()->route('agents.index')->with('success', 'Agent mis à jour.');
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();
        return redirect()->route('agents.index')->with('success', 'Agent supprimé.');
    }
}
