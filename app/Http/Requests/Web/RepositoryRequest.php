<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class RepositoryRequest extends FormRequest
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

    public function getRepositoryName() : string
    {
        return $this->get('repository-name');
    }

    public function getRepositoryDescription() : string
    {
        return $this->get('repository-description');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'repository-name' => 'required|string',
            'repository-description' => 'required|string'
        ];
    }
}
