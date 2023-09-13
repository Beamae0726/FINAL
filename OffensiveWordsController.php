<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyOffensiveWordRequest;
use App\Http\Requests\StoreOffensiveWordRequest;
use App\Http\Requests\UpdateOffensiveWordRequest;
use App\Models\OffensiveWord;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OffensiveWordsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('offensive_word_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offensiveWords = OffensiveWord::all();

        return view('admin.offensiveWords.index', compact('offensiveWords'));
    }

    public function create()
    {
        abort_if(Gate::denies('offensive_word_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.offensiveWords.create');
    }

    public function store(StoreOffensiveWordRequest $request)
    {
        $offensiveWord = OffensiveWord::create($request->all());

        return redirect()->route('admin.offensive-words.index');
    }

    public function edit(OffensiveWord $offensiveWord)
    {
        abort_if(Gate::denies('offensive_word_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.offensiveWords.edit', compact('offensiveWord'));
    }

    public function update(UpdateOffensiveWordRequest $request, OffensiveWord $offensiveWord)
    {
        $offensiveWord->update($request->all());

        return redirect()->route('admin.offensive-words.index');
    }

    public function show(OffensiveWord $offensiveWord)
    {
        abort_if(Gate::denies('offensive_word_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.offensiveWords.show', compact('offensiveWord'));
    }

    public function destroy(OffensiveWord $offensiveWord)
    {
        abort_if(Gate::denies('offensive_word_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offensiveWord->delete();

        return back();
    }

    public function massDestroy(MassDestroyOffensiveWordRequest $request)
    {
        $offensiveWords = OffensiveWord::find(request('ids'));

        foreach ($offensiveWords as $offensiveWord) {
            $offensiveWord->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
