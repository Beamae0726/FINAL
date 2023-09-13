<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReliableSourceRequest;
use App\Http\Requests\UpdateReliableSourceRequest;
use App\Http\Resources\Admin\ReliableSourceResource;
use App\Models\ReliableSource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReliableSourceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('reliable_source_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReliableSourceResource(ReliableSource::all());
    }

    public function store(StoreReliableSourceRequest $request)
    {
        $reliableSource = ReliableSource::create($request->all());

        return (new ReliableSourceResource($reliableSource))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ReliableSource $reliableSource)
    {
        abort_if(Gate::denies('reliable_source_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReliableSourceResource($reliableSource);
    }

    public function update(UpdateReliableSourceRequest $request, ReliableSource $reliableSource)
    {
        $reliableSource->update($request->all());

        return (new ReliableSourceResource($reliableSource))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ReliableSource $reliableSource)
    {
        abort_if(Gate::denies('reliable_source_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reliableSource->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
