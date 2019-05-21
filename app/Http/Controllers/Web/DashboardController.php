<?php

namespace App\Http\Controllers\Web;

use App\Label\LabelManager;
use App\Milestone\MilestoneManager;
use App\Repository\RepositoryManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /** @var  RepositoryManager */
    private $repositoryManager;

    /** @var LabelManager */
    private $labelManager;

    /** @var MilestoneManager */
    private $milestoneManager;

    public function __construct(
        RepositoryManager $repositoryManager,
        LabelManager $labelManager,
        MilestoneManager $milestoneManager
    ) {
        $this->repositoryManager = $repositoryManager;
        $this->labelManager = $labelManager;
        $this->milestoneManager = $milestoneManager;
    }

    public function index()
    {
        return view('dashboard.index', [
            'repos' => $this->repositoryManager->getRepositories()
        ]);
    }

    public function fetch(Request $request)
    {
        return view('audit.index', [
            'repo' => $this->repositoryManager->getRepository($request->repository),
            'labels' => $this->labelManager->getRepositoryIssueLabels(),
            'milestones' => $this->milestoneManager->getMilestones()
        ]);
    }
}
