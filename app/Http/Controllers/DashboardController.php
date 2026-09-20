<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Assignment;
use App\Models\Site;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $activeAgentsCount = Agent::where('status', 'active')->count();
        $sitesCount = Site::count();
        $ongoingAssignmentsCount = Assignment::where(function ($query) {
            $query->whereNull('ends_at')->orWhere('ends_at', '>=', now());
        })->count();

        $recentAssignments = Assignment::with(['agent', 'site'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'activeAgentsCount',
            'sitesCount',
            'ongoingAssignmentsCount',
            'recentAssignments',
        ));
    }
}
