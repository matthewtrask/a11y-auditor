<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Requests\Web\IssueRequest;
use App\Issue\Issue;
use App\Issue\IssueManager;
use App\Http\Controllers\Controller;
use App\Label\LabelManager;
use App\Milestone\MilestoneManager;
use App\Repository\RepositoryManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class IssueController extends Controller
{
    /** @var IssueManager */
    private $issueManager;

    /** @var MilestoneManager */
    private $milestoneManager;

    public function __construct(IssueManager $issueManager, MilestoneManager $milestoneManager)
    {
        $this->issueManager= $issueManager;
        $this->milestoneManager = $milestoneManager;
    }

    public function create(IssueRequest $request)
    {
        $issue = $this->createIssue($request);

        $created = $this->issueManager->createIssue($issue, $request->repository);

        if ($created) {
            //return Redirect::to('/')->with('message', sprintf('%s repository created!', $request->getRepositoryName()));
        }
    }

    public function edit(IssueRequest $request)
    {
        if ($request->getMethod() === 'POST') {

        }

        return view('issue.index', [
           'issue' => $this->issueManager->getIssueByNumber($request->repository, (int) $request->id)
        ]);
    }

    private function createIssue(IssueRequest $request) : Issue
    {
        $issue = new Issue();
        $issue->setTitle($request->getTitle());
        $issue->setProject($request->getProject());
        $issue->setDescription($request->getDescription());
        $issue->setTags($request->getIssueLabels());
        $issue->setMilestone($this->milestoneManager->findMilestoneForId((int) $request->getMilestone()));

        return $issue;
    }
}
