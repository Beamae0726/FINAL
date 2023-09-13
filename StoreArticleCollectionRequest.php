<?php

namespace App\Http\Requests;

use App\Models\ArticleCollection;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreArticleCollectionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('article_collection_create');
    }

    public function rules()
    {
        return [
            'category_id' => [
                'required',
                'integer',
            ],
            'title' => [
                'string',
                'required',
                'unique:article_collections',
            ],
            'details' => [
                'required',
            ],
        ];
    }
}
