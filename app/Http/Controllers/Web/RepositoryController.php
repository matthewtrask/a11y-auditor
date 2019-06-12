<?php

namespace App\Http\Controllers\Web;

use App\Http\Requests\Web\RepositoryRequest;
use App\Issue\IssueManager;
use App\Label\Label;
use App\Label\LabelManager;
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

    /** @var LabelManager */
    private $labelManager;

    public function __construct(
        RepositoryManager $repositoryManager,
        IssueManager $issueManager,
        MilestoneManager $milestoneManager,
        LabelManager $labelManager
    ) {
        $this->repositoryManager = $repositoryManager;
        $this->issueManager = $issueManager;
        $this->milestoneManager = $milestoneManager;
        $this->labelManager = $labelManager;
    }

    public function index(Request $request)
    {
        return view('repository.index', [
            'repo'       => $this->repositoryManager->getRepository($request->repository),
            'issues'     => $this->issueManager->getIssuesForRepository($request->repository),
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

    public function create(RepositoryRequest $request)
    {
        $this->repositoryManager->createRepository(
            $request->getRepositoryName(),
            $request->getRepositoryDescription()
        );

        return redirect()
            ->action('Web\RepositoryController@index', ['repository' => $request->getRepositoryName()])
            ->with('message', sprintf('%s repository created!', $request->getRepositoryName()));
    }

    public function edit(RepositoryRequest $request)
    {
        if ($request->getMethod() === 'POST') {
            $this->issueManager->editIssue($request);
        }

        return view('repository.edit', [
            'repo'       => $this->repositoryManager->getRepository($request->repository),
            'issues'     => $this->issueManager->getIssuesForRepository($request->repository),
        ]);
    }

    public function destroy(Request $request)
    {
        $res = $this->repositoryManager->deleteRepository($request->repository);

        if ($res->getStatusCode() === 204) {
            return true;
        }
    }
}
