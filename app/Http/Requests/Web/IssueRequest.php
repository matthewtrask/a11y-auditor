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

    public function getIssueLabels()
    {
        return $this->get('issue-labels');
    }

    public function getDescription()
    {
        return $this->get('issue-description');
    }

    public function getCurrentCode()
    {
        return $this->get('issue-current-code');
    }

    public function getSolution()
    {
        return $this->get('issue-solution');
    }

    public function getSuggestedCode()
    {
        return $this->get('issue-suggested-code');
    }

    public function getAffectedCommunities()
    {
        return $this->get('issue-affected-communities');
    }

    public function getIssueEnvironment()
    {
        return $this->get('issue-environment');
    }

    public function getMilestone()
    {
        return (int) $this->get('issue-milestone');
    }

    public function rules()
    {
        return [
            'issue-title'                   => 'nullable|string',
            'issue-description'             => 'nullable|string',
            'issue-current-code'            => 'nullable|string',
            'issue-solution'                => 'nullable|string',
            'issue-suggested-code'          => 'nullable|string',
            'issue-affected-communities'    => 'nullable|array',
            'issue-environment'             => 'nullable|string',
            'issue-labels'                  => 'nullable|array',
            'issue-milestone'               => 'nullable|integer',
        ];
    }
}
