<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BookStoreRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (!empty($this->alias))
            return;

        $this->merge([
            'alias' => Str::slug($this->title),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'max:250'],
            'alias' => ['unique:books,alias'],
            'description' => ['string'],
            'category' => ['required', 'exists:categories,id'],
            'authors' => ['array'],
            'authors.*' => ['exists:authors,id']
        ];
    }
}
