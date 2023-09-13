<?php

namespace App\Http\Requests;

use App\Models\BlockIp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBlockIpRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('block_ip_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:block_ips,id',
        ];
    }
}
