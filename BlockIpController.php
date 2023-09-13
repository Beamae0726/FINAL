<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyBlockIpRequest;
use App\Http\Requests\StoreBlockIpRequest;
use App\Http\Requests\UpdateBlockIpRequest;
use App\Models\BlockIp;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockIpController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('block_ip_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blockIps = BlockIp::all();

        return view('admin.blockIps.index', compact('blockIps'));
    }

    public function create()
    {
        abort_if(Gate::denies('block_ip_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.blockIps.create');
    }

    public function store(StoreBlockIpRequest $request)
    {
        $blockIp = BlockIp::create($request->all());

        return redirect()->route('admin.block-ips.index');
    }

    public function edit(BlockIp $blockIp)
    {
        abort_if(Gate::denies('block_ip_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.blockIps.edit', compact('blockIp'));
    }

    public function update(UpdateBlockIpRequest $request, BlockIp $blockIp)
    {
        $blockIp->update($request->all());

        return redirect()->route('admin.block-ips.index');
    }

    public function show(BlockIp $blockIp)
    {
        abort_if(Gate::denies('block_ip_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.blockIps.show', compact('blockIp'));
    }

    public function destroy(BlockIp $blockIp)
    {
        abort_if(Gate::denies('block_ip_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $blockIp->delete();

        return back();
    }

    public function massDestroy(MassDestroyBlockIpRequest $request)
    {
        $blockIps = BlockIp::find(request('ids'));

        foreach ($blockIps as $blockIp) {
            $blockIp->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
