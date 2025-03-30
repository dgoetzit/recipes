<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetTopRecipesController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $recipes = Recipe::query()
            ->orderBy('views', 'desc')
            ->limit(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $recipes,
        ]);
    }
}
