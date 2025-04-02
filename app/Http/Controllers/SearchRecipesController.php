<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchRecipesController extends Controller
{
    private const DEFAULT_LIMIT = 5;

    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'nullable|string|min:2',
        ]);

        $limit = (int) $request->input('limit', self::DEFAULT_LIMIT);

        $query = Recipe::query();

        if (! $request->filled('q')) {
            $recipes = Recipe::latest()
                ->take($limit)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $recipes,
            ]);
        }

        $searchTerm = $request->input('q');

        $query->where(function (Builder $query) use ($searchTerm) {
            $query->where('name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                ->orWhereHas('steps', function (Builder $query) use ($searchTerm) {
                    $query->where('description', 'LIKE', "%{$searchTerm}%");
                })
                ->orWhereHas('ingredients', function (Builder $query) use ($searchTerm) {
                    $query->where('ingredients.name', 'LIKE', "%{$searchTerm}%");
                });
        });

        $recipes = $query->with(['ingredients', 'steps'])
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $recipes,
        ]);
    }
}
