<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssignmentResource;
use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function index()
    {
        $assignments = Assignment::with(['agent', 'site'])->latest()->paginate(15);

        return AssignmentResource::collection($assignments);
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

        $assignment = Assignment::create($data)->load(['agent', 'site']);

        return AssignmentResource::make($assignment)->response()->setStatusCode(201);
    }

    public function show(Assignment $assignment)
    {
        return AssignmentResource::make($assignment->load(['agent', 'site']));
    }

    public function update(Request $request, Assignment $assignment)
    {
        $data = $request->validate([
            'agent_id' => 'sometimes|required|exists:agents,id',
            'site_id' => 'sometimes|required|exists:sites,id',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'role' => 'nullable|string|max:255',
        ]);

        $assignment->update($data);

        return AssignmentResource::make($assignment->load(['agent', 'site']));
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();

        return response()->noContent();
    }
}
