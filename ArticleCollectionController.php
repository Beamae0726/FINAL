<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyArticleCollectionRequest;
use App\Http\Requests\StoreArticleCollectionRequest;
use App\Http\Requests\UpdateArticleCollectionRequest;
use App\Models\ArticleCollection;
use App\Models\Category;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ArticleCollectionController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('article_collection_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleCollections = ArticleCollection::with(['category'])->get();

        return view('admin.articleCollections.index', compact('articleCollections'));
    }

    public function create()
    {
        abort_if(Gate::denies('article_collection_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.articleCollections.create', compact('categories'));
    }

    public function store(StoreArticleCollectionRequest $request)
    {
        $articleCollection = ArticleCollection::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $articleCollection->id]);
        }

        return redirect()->route('admin.article-collections.index');
    }

    public function edit(ArticleCollection $articleCollection)
    {
        abort_if(Gate::denies('article_collection_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $articleCollection->load('category');

        return view('admin.articleCollections.edit', compact('articleCollection', 'categories'));
    }

    public function update(UpdateArticleCollectionRequest $request, ArticleCollection $articleCollection)
    {
        $articleCollection->update($request->all());

        return redirect()->route('admin.article-collections.index');
    }

    public function show(ArticleCollection $articleCollection)
    {
        abort_if(Gate::denies('article_collection_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleCollection->load('category');

        return view('admin.articleCollections.show', compact('articleCollection'));
    }

    public function destroy(ArticleCollection $articleCollection)
    {
        abort_if(Gate::denies('article_collection_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $articleCollection->delete();

        return back();
    }

    public function massDestroy(MassDestroyArticleCollectionRequest $request)
    {
        $articleCollections = ArticleCollection::find(request('ids'));

        foreach ($articleCollections as $articleCollection) {
            $articleCollection->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('article_collection_create') && Gate::denies('article_collection_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ArticleCollection();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
