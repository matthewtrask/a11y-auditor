<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Comment\CommentManager;
use App\Http\Requests\Web\IssueRequest;
use App\Issue\Issue;
use App\Issue\IssueManager;
use App\Http\Controllers\Controller;
use App\Milestone\MilestoneManager;
use App\Repository\RepositoryManager;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    /** @var IssueManager */
    private $issueManager;

    /** @var MilestoneManager */
    private $milestoneManager;

    /** @var CommentManager */
    private $commentManager;

    /** @var RepositoryManager */
    private $repositoryManager;

    public function __construct(
        IssueManager $issueManager,
        MilestoneManager $milestoneManager,
        CommentManager $commentManager,
        RepositoryManager $repositoryManager)
    {
        $this->issueManager= $issueManager;
        $this->milestoneManager = $milestoneManager;
        $this->commentManager = $commentManager;
        $this->repositoryManager = $repositoryManager;
    }

    public function create(IssueRequest $request)
    {
        $issue = $this->createIssue($request);

        $this->issueManager->createIssue($issue, $request->repository);

        return redirect()
            ->action('Web\RepositoryController@index', ['repository' => $request->repository])
            ->with('message', 'The issue has been created!');
    }

    public function fetch(Request $request)
    {
        $repo = $this->repositoryManager->getRepository($request->repository);

        $issue = $this->issueManager->getIssueByNumber($request->repository, (int) $request->id);

        $comments = $this->commentManager->getCommentsForIssue($request->repository, $issue->getNumber());

        return view('issue.index', [
            'repo' => $repo,
            'issue' => $issue,
            'comments' => $comments,
        ]);
    }

    public function close(Request $request)
    {
        $closed = $this->issueManager->closeIssue($request->repository, (int) $request->id);

        if ($closed) {
            return redirect()
                ->action('Web\RepositoryController@index', ['repository' => $request->repository])
                ->with('message', 'The issue has been closed!');
        }

        return redirect()
            ->action('Web\RepositoryController@index', ['repository' => $request->repository])
            ->with('message', 'The was an issue closing the issue. Please try again later.');
    }

    private function createIssue(IssueRequest $request) : Issue
    {
        $issue = new Issue();
        $issue->setTitle($request->getTitle());
        $issue->setDescription($request->getDescription());
        $issue->setCurrentCode($request->getCurrentCode());
        $issue->setAffectedCommunities(implode(" ", $request->getAffectedCommunities()));
        $issue->setSuggestedCode($request->getSuggestedCode());
        $issue->setEnvironment($request->getIssueEnvironment());
        $issue->setSolution($request->getSolution());
        $issue->setTags($request->getIssueLabels());
        $issue->setMilestone($this->milestoneManager->findMilestoneForId((int) $request->getMilestone()));

        return $issue;
    }
}
