<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class IssueRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getTitle()
    {
        return $this->get('issue-title');
    }

    public function getProject()
    {
        return $this->get('issue-project');
    }

    public function getIssueLabels()
    {
        return $this->get('issue-labels');
    }

    public function getDescription()
    {
        return $this->get('issue-description');
    }

    public function getMilestone()
    {
        return (int) $this->get('issue-milestone');
    }

    public function rules()
    {
        return [
            'issue-title'       => 'nullable|string',
            'issue-project'     => 'nullable|string',
            'issue-description' => 'nullable|string',
            'issue-labels'      => 'nullable|array',
            'issue-milestone'   => 'nullable|integer',
        ];
    }
}
