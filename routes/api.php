<?php

declare(strict_types=1);

use App\Http\Controllers\GetRelatedRecipesController;
use App\Http\Controllers\GetTopRecipesController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SearchRecipesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('recipes')->name('recipes.')->group(function () {
    Route::get('/', [RecipeController::class, 'index'])->name('index');
    Route::get('/top', GetTopRecipesController::class)->name('top');
    Route::get('/related', GetRelatedRecipesController::class)->name('related');
    Route::get('/search', SearchRecipesController::class)->name('search');
    Route::get('/{recipe:slug}', [RecipeController::class, 'show'])->name('show');
});
