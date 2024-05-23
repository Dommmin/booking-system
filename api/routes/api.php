<?php

declare(strict_types=1);

use App\Http\Controllers\Api\v1\Auth\CurrentUserController;
use App\Http\Controllers\Api\v1\Auth\SocialiteLoginController;
use App\Http\Controllers\Api\v1\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Api\v1\ImageController;
use App\Http\Controllers\Api\v1\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);
Route::get('/user', fn (Request $request) => $request->user())->middleware('auth:sanctum');

Route::delete('/user', [CurrentUserController::class, 'destroy'])
    ->middleware('auth:sanctum')
    ->name('user.destroy');

Route::get('/two-factor-authentication-enabled', [
    TwoFactorAuthenticationController::class, 'enabled',
])->name('two-factor-authentication.enabled');

Route::get('/two-factor-authentication-challenge', [
    TwoFactorAuthenticationController::class, 'challenge',
])->name('two-factor-authentication.challenge')
    ->middleware(['guest:' . config('fortify.guard')]);

Route::prefix('auth/{provider}')->group(function (): void {
    Route::get('/url', [SocialiteLoginController::class, 'redirectToProvider']);
    Route::get('/callback', [SocialiteLoginController::class, 'handleProviderCallback']);
});

Route::apiResource('images', ImageController::class);
Route::get('search', SearchController::class);
