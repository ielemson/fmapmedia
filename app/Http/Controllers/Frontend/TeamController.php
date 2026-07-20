<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\View\View;

class TeamController extends Controller
{
    // public function index(): View
    // {
    //     $teamMembers = TeamMember::query()
    //         ->with('user')
    //         ->published()
    //         ->orderBy('display_order')
    //         ->latest()
    //         ->paginate(12);

    //     return view('frontend.team.index', compact('teamMembers'));
    // }

    public function show(TeamMember $teamMember): View
    {
        abort_unless(
            $teamMember->is_active &&
            (
                is_null($teamMember->published_at) ||
                $teamMember->published_at->lte(now())
            ),
            404
        );

        $teamMember->load('user');

        return view('frontend.team.show', compact('teamMember'));
    }
}