<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyReliableSourceRequest;
use App\Http\Requests\StoreReliableSourceRequest;
use App\Http\Requests\UpdateReliableSourceRequest;
use App\Models\ReliableSource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReliableSourceController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('reliable_source_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reliableSources = ReliableSource::all();

        return view('admin.reliableSources.index', compact('reliableSources'));
    }

    public function create()
    {
        abort_if(Gate::denies('reliable_source_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reliableSources.create');
    }

    public function store(StoreReliableSourceRequest $request)
    {
        $reliableSource = ReliableSource::create($request->all());

        return redirect()->route('admin.reliable-sources.index');
    }

    public function edit(ReliableSource $reliableSource)
    {
        abort_if(Gate::denies('reliable_source_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reliableSources.edit', compact('reliableSource'));
    }

    public function update(UpdateReliableSourceRequest $request, ReliableSource $reliableSource)
    {
        $reliableSource->update($request->all());

        return redirect()->route('admin.reliable-sources.index');
    }

    public function show(ReliableSource $reliableSource)
    {
        abort_if(Gate::denies('reliable_source_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reliableSources.show', compact('reliableSource'));
    }

    public function destroy(ReliableSource $reliableSource)
    {
        abort_if(Gate::denies('reliable_source_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reliableSource->delete();

        return back();
    }

    public function massDestroy(MassDestroyReliableSourceRequest $request)
    {
        $reliableSources = ReliableSource::find(request('ids'));

        foreach ($reliableSources as $reliableSource) {
            $reliableSource->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
