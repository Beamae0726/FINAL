<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOffensiveWordRequest;
use App\Http\Requests\UpdateOffensiveWordRequest;
use App\Http\Resources\Admin\OffensiveWordResource;
use App\Models\OffensiveWord;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OffensiveWordsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('offensive_word_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OffensiveWordResource(OffensiveWord::all());
    }

    public function store(StoreOffensiveWordRequest $request)
    {
        $offensiveWord = OffensiveWord::create($request->all());

        return (new OffensiveWordResource($offensiveWord))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(OffensiveWord $offensiveWord)
    {
        abort_if(Gate::denies('offensive_word_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OffensiveWordResource($offensiveWord);
    }

    public function update(UpdateOffensiveWordRequest $request, OffensiveWord $offensiveWord)
    {
        $offensiveWord->update($request->all());

        return (new OffensiveWordResource($offensiveWord))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(OffensiveWord $offensiveWord)
    {
        abort_if(Gate::denies('offensive_word_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offensiveWord->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
