<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetTopRecipesController extends Controller
{
    private const DEFAULT_LIMIT = 3;

    public function __invoke(Request $request): JsonResponse
    {
        $limit = (int) $request->input('limit', self::DEFAULT_LIMIT);

        $recipes = Recipe::query()
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $recipes,
        ]);
    }
}
