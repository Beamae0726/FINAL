<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreArticleCollectionRequest;
use App\Http\Requests\UpdateArticleCollectionRequest;
use App\Http\Resources\Admin\ArticleCollectionResource;
use App\Models\ArticleCollection;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleCollectionApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('article_collection_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ArticleCollectionResource(ArticleCollection::with(['category'])->get());
    }

    public function store(StoreArticleCollectionRequest $request)
    {
        $articleCollection = ArticleCollection::create($request->all());

        return (new ArticleCollectionResource($articleCollection))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ArticleCollection $articleCollection)
    {
        abort_if(Gate::denies('article_collection_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ArticleCollectionResource($articleCollection->load(['category']));
    }

    public function update(UpdateArticleCollectionRequest $request, ArticleCollection $articleCollection)
    {
        $articleCollection->update($request->all());

        return (new ArticleCollectionResource($articleCollection))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ArticleCollection $articleCollection)
    {
        abort_if(Gate::denies('article_collection_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleCollection->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
