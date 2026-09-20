<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AgentController extends Controller
{
    public function index()
    {
        return AgentResource::collection(Agent::orderBy('name')->paginate(15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'phone' => 'nullable|string|max:50',
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        $agent = Agent::create($data);

        return AgentResource::make($agent)->response()->setStatusCode(201);
    }

    public function show(Agent $agent)
    {
        return AgentResource::make($agent);
    }

    public function update(Request $request, Agent $agent)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'email', Rule::unique('agents')->ignore($agent->id)],
            'phone' => 'nullable|string|max:50',
            'status' => ['sometimes', 'required', Rule::in(['active', 'inactive'])],
        ]);

        $agent->update($data);

        return AgentResource::make($agent);
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();

        return response()->noContent();
    }
}
