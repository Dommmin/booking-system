<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceStoreRequest;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return Service::get();
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
}
