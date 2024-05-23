<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\v1;

use App\Constants\UserConstants;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\UserRepository;

class EmployeeController extends Controller
{
    public function index()
    {
        return User::employee()->get(['id', 'name', 'slug']);
    }

    public function show(string $slug)
    {
        return app(UserRepository::class)->getEmployeeBySlug($slug, ['id', 'name', 'slug']);
    }
}
