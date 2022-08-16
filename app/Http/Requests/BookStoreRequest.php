<?php

namespace App\Http\Requests;

use App\Rules\Isbn;
use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "title" => "required",
            "description" => ["required","min:20"],
            "author_id" => "exists:authors,id",
            "ISBN" => [new Isbn()]

        ];
    }

    public function messages()
    {
        return [
            "title.required" => "title is required",
            "description.required" => "description is required",
            "description.min" => "description minimum length is 20",
            "author_id.exists" => "Author must be valid"
        ];
    }

}
