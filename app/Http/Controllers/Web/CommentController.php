<?php

namespace App\Http\Controllers\Web;

use App\Comment\CommentManager;
use App\Http\Requests\Web\CommentRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /** @var CommentManager */
    private $commentManager;

    public function __construct(CommentManager $commentManager)
    {
        $this->commentManager = $commentManager;
    }

    public function create(CommentRequest $request)
    {
        $this->commentManager->createCommentForIssue($request->getBody(), $request->repository, $request->issueNumber);

        $redirectLink = sprintf('/%s/issues/%s', $request->repository, $request->issueNumber);

        return redirect($redirectLink)->with('message', 'Comment added!');
    }
}
