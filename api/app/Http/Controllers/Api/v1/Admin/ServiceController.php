<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ServiceStoreRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends ApiController
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('perPage')) {
            return $query->simplePaginate($request->input('perPage', 5))->withQueryString();
        }

        return $query->get();
    }

    public function store(ServiceStoreRequest $request)
    {
        $validated = $request->validated();

        return Service::create($validated);
    }

    public function show(Service $service)
    {
        return $service;
    }

    public function update(ServiceStoreRequest $request, Service $service)
    {
        $service->update($request->validated());
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return response()->noContent();
    }
}
