<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Requests\Web\IssueRequest;
use App\Issue\Issue;
use App\Issue\IssueManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class IssueController extends Controller
{
    /** @var IssueManager */
    private $issueManager;

    public function __construct(IssueManager $issueManager)
    {
        $this->issueManager= $issueManager;
    }

    public function create(IssueRequest $request)
    {
        $issue = $this->createIssue($request);

        $created = $this->issueManager->createIssue($issue, $request->repository);

        if ($created) {
            //return Redirect::to('/')->with('message', sprintf('%s repository created!', $request->getRepositoryName()));
        }
    }

    private function createIssue(IssueRequest $request) : Issue
    {
        $issue = new Issue();
        $issue->setTitle($request->getTitle());
        $issue->setProject($request->getProject());
        $issue->setDescription($request->getDescription());
        $issue->setTags($request->getIssueLabels());
        $issue->setMilestone($request->getMilestone());

        return $issue;
    }
}
