<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique',
            'articles' => 'array',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'name.required' => 'A name is required',
            'name.unique' => 'A name must be unique',
            'articles.array' => 'A articles must be array',
        ];
    }
}
