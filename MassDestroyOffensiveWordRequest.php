<?php

namespace App\Http\Requests;

use App\Models\OffensiveWord;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOffensiveWordRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('offensive_word_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:offensive_words,id',
        ];
    }
}
