<?php

namespace App\Http\Controllers\Web;

use App\Milestone\MilestoneManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MilestoneController extends Controller
{
    /** @var MilestoneManager */
    private $milestoneManager;

    public function __construct(MilestoneManager $milestoneManager)
    {
        $this->milestoneManager = $milestoneManager;
    }

    public function fetch(Request $request)
    {
        $milestones = $this->milestoneManager->getMilestonesForRepository($request->repository);

        return view('milestone.index', [
            'repo' => $request->repository,
            'milestones' => $milestones
        ]);
    }
}
