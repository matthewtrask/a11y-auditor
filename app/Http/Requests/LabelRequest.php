<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelRequest extends FormRequest
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

    public function getName()
    {
        return $this->get('label-name');
    }

    public function getColor()
    {
        return $this->get('label-color');
    }

    public function getDescription()
    {
        return $this->get('label-description');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'label-name'        => 'required|string',
            'label-color'       => 'required|string',
            'label-description' => 'required|string'
        ];
    }
}
