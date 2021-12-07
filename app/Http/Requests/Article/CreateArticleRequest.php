<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
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
            'title' => 'required|string|unique',
            'content' => 'required|string',
            'tags' => 'array',
        ];
    }

    /**
     * @return string[]
     */
    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'title.unique' => 'A title must be unique',
            'content.required' => 'A content is required',
            'tags.array' => 'A tags must be array',
        ];
    }
}
