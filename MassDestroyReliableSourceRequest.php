<?php

namespace App\Http\Requests;

use App\Models\ReliableSource;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyReliableSourceRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('reliable_source_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:reliable_sources,id',
        ];
    }
}
