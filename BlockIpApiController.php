<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlockIpRequest;
use App\Http\Requests\UpdateBlockIpRequest;
use App\Http\Resources\Admin\BlockIpResource;
use App\Models\BlockIp;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockIpApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('block_ip_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BlockIpResource(BlockIp::all());
    }

    public function store(StoreBlockIpRequest $request)
    {
        $blockIp = BlockIp::create($request->all());

        return (new BlockIpResource($blockIp))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BlockIp $blockIp)
    {
        abort_if(Gate::denies('block_ip_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BlockIpResource($blockIp);
    }

    public function update(UpdateBlockIpRequest $request, BlockIp $blockIp)
    {
        $blockIp->update($request->all());

        return (new BlockIpResource($blockIp))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BlockIp $blockIp)
    {
        abort_if(Gate::denies('block_ip_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blockIp->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
