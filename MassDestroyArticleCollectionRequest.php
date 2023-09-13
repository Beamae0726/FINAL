<?php

namespace App\Http\Requests;

use App\Models\ArticleCollection;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyArticleCollectionRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('article_collection_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:article_collections,id',
        ];
    }
}
