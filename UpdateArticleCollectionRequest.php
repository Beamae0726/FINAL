<?php

namespace App\Http\Requests;

use App\Models\ArticleCollection;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateArticleCollectionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('article_collection_edit');
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
                'unique:article_collections,title,' . request()->route('article_collection')->id,
            ],
            'details' => [
                'required',
            ],
        ];
    }
}
