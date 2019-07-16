<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabelRequest;
use App\Label\LabelManager;

class LabelController extends Controller
{
    /** @var LabelManager */
    private $labelManager;

    public function __construct(LabelManager $labelManager)
    {
        $this->labelManager = $labelManager;
    }

    public function index()
    {
        $labels = $this->labelManager->getRepositoryIssueLabels();

        return view('labels.index', [
            'labels' => $labels
        ]);
    }

    public function create(LabelRequest $request)
    {
        $this->labelManager->createLabel($request->getName(), $request->getColor(), $request->getDescription());

        return redirect('/labels')->with('message',
            sprintf(
                'Label %s added successfully!',
                    $request->getName()
            )
        );
    }
}