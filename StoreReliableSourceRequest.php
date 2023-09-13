<?php

namespace App\Http\Requests;

use App\Models\ReliableSource;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreReliableSourceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('reliable_source_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:reliable_sources',
            ],
            'source_url' => [
                'string',
                'required',
                'unique:reliable_sources',
            ],
        ];
    }
}
