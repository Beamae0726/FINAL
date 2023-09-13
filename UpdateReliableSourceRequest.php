<?php

namespace App\Http\Requests;

use App\Models\ReliableSource;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateReliableSourceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('reliable_source_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:reliable_sources,name,' . request()->route('reliable_source')->id,
            ],
            'source_url' => [
                'string',
                'required',
                'unique:reliable_sources,source_url,' . request()->route('reliable_source')->id,
            ],
        ];
    }
}
