<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchRecipesController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'nullable|string|min:2',
            'limit' => 'nullable|integer|min:1|max:50',
        ]);

        $query = Recipe::query();
        $limit = 5;

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

        $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                ->orWhereHas('steps', function ($query) use ($searchTerm) {
                    $query->where('description', 'LIKE', "%{$searchTerm}%");
                })
                ->orWhereHas('ingredients', function ($query) use ($searchTerm) {
                    $query->where('ingredients.name', 'LIKE', "%{$searchTerm}%");
                })
                ->orWhere('email', 'LIKE', "%{$searchTerm}%");
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
