<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SiteResource;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        return SiteResource::collection(Site::orderBy('name')->paginate(15));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
        ]);

        $site = Site::create($data);

        return SiteResource::make($site)->response()->setStatusCode(201);
    }

    public function show(Site $site)
    {
        return SiteResource::make($site);
    }

    public function update(Request $request, Site $site)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
        ]);

        $site->update($data);

        return SiteResource::make($site);
    }

    public function destroy(Site $site)
    {
        $site->delete();

        return response()->noContent();
    }
}
