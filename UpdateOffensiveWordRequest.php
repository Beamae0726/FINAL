<?php

namespace App\Http\Requests;

use App\Models\OffensiveWord;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOffensiveWordRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('offensive_word_edit');
    }

    public function rules()
    {
        return [
            'word' => [
                'string',
                'required',
            ],
        ];
    }
}
