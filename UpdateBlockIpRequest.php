<?php

namespace App\Http\Requests;

use App\Models\BlockIp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBlockIpRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('block_ip_edit');
    }

    public function rules()
    {
        return [
            'address' => [
                'string',
                'required',
            ],
        ];
    }
}
