<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        ray('search', [
            'email' => $request->email,
            'keyword' => $request->keyword,
            'ingredient' => $request->ingredient,
        ]);

        $validated = $request->validate([
            'email' => 'nullable|email',
            'keyword' => 'nullable|string|min:2',
            'ingredient' => 'nullable|string|min:2',
        ]);

        $query = Recipe::query();

        if ($request->filled('email')) {
            $query->where('email', $request->email);
        }

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%")
                  ->orWhereHas('steps', function($query) use ($keyword) {
                      $query->where('description', 'LIKE', "%{$keyword}%");
                  })
                  ->orWhereHas('ingredients', function($query) use ($keyword) {
                      $query->where('ingredients.name', 'LIKE', "%{$keyword}%");
                  });
            });
        }

        if ($request->filled('ingredient')) {
            $ingredient = $request->ingredient;
            $query->whereHas('ingredients', function($q) use ($ingredient) {
                $q->where('ingredients.name', 'LIKE', "%{$ingredient}%")
                  ->orWhere('ingredient_recipe.measure_amount', 'LIKE', "%{$ingredient}%");
            });
        }

        $recipes = $query->with(['ingredients', 'steps'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(12);

        return response()->json([
            'success' => true,
            'data' => $recipes,
        ]);
    }

    public function show(Recipe $recipe): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $recipe->load(['ingredients', 'steps']),
        ]);
    }
}
