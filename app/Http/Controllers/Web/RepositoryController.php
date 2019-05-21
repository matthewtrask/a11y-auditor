<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\Web\RepositoryRequest;
use App\Issue\IssueManager;
use App\Milestone\MilestoneManager;
use App\Repository\RepositoryManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class RepositoryController extends Controller
{
    /** @var RepositoryManager */
    private $repositoryManager;

    /** @var IssueManager */
    private $issueManager;

    /** @var MilestoneManager */
    private $milestoneManager;

    public function __construct(RepositoryManager $repositoryManager, IssueManager $issueManager, MilestoneManager $milestoneManager)
    {
        $this->repositoryManager = $repositoryManager;
        $this->issueManager = $issueManager;
        $this->milestoneManager = $milestoneManager;
    }

    public function index(Request $request)
    {
        return view('repository.index', [
            'repo'       => $this->repositoryManager->getRepository($request->repository),
            'issues'     => $this->issueManager->getIssuesForRepository($request->repository),
        ]);
    }

    public function create(RepositoryRequest $request)
    {
        $created = $this->repositoryManager->createRepository(
            $request->getRepositoryName(),
            $request->getRepositoryDescription()
        );

        if ($created) {
            return Redirect::to('/')->with('message', sprintf('%s repository created!', $request->getRepositoryName()));
        }
    }

    public function edit(RepositoryRequest $request)
    {

    }

    public function destroy(Request $request)
    {
        $res = $this->repositoryManager->deleteRepository($request->repository);

        if ($res->getStatusCode() === 204) {
            return true;
        }
    }
}
