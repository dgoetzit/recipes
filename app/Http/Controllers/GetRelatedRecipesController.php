<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as SupportCollection;

class GetRelatedRecipesController extends Controller
{
    private const DEFAULT_LIMIT = 6;

    public function __invoke(Request $request): JsonResponse
    {
        $recipeId = (int) $request->input('id');
        $limit = (int) $request->input('limit', self::DEFAULT_LIMIT);
        $by = $request->input('by');

        $recipes = $recipeId
            ? $this->findRelatedRecipes($recipeId, $limit, $by)
            : $this->getTopViewedRecipes($limit);

        return response()->json([
            'success' => true,
            'data' => $recipes,
        ]);
    }

    public function findRelatedRecipes(int $recipeId, int $limit, string $by = null): SupportCollection
    {
        $recipe = Recipe::find($recipeId);

        if (! $recipe) {
            return $this->getTopViewedRecipes($limit);
        }

        $relatedRecipeStrategies = match ($by) {
            'name' => [fn () => $this->findRecipesByName($recipe, $limit)],
            'ingredient' => [fn () => $this->findRecipesByIngredients($recipe, $limit)],
            default => [
                fn () => $this->findRecipesByName($recipe, $limit),
                fn () => $this->findRecipesByIngredients($recipe, $limit),
                fn () => $this->getTopViewedRecipes($limit, [$recipeId]),
            ]
        };

        $relatedRecipes = $this->applyRelatedRecipeStrategies(
            $relatedRecipeStrategies,
            $limit
        );

        return $relatedRecipes;
    }

    private function applyRelatedRecipeStrategies(array $strategies, int $limit): SupportCollection
    {
        $relatedRecipes = collect();

        foreach ($strategies as $strategy) {
            $currentResults = $strategy();
            $relatedRecipes = $relatedRecipes->merge($currentResults);

            if ($relatedRecipes->count() >= $limit) {
                break;
            }
        }

        return $relatedRecipes->unique('id')->take($limit);
    }

    private function findRecipesByName(Recipe $recipe, int $limit): Collection
    {
        $nameWords = collect(explode(' ', $recipe->name))
            ->filter(fn ($word) => strlen($word) > 3)
            ->map(fn ($word) => trim($word));

        return Recipe::query()
            ->where('id', '!=', $recipe->id)
            ->where(function (Builder $query) use ($recipe, $nameWords) {
                $query->orWhere('name', 'LIKE', '%' . $recipe->name . '%');

                $nameWords->each(function ($word) use ($query) {
                    $query->orWhere('name', 'LIKE', '%' . $word . '%');
                });
            })
            ->limit($limit)
            ->get();
    }

    private function findRecipesByIngredients(Recipe $recipe, int $limit): Collection
    {
        return Recipe::query()
            ->where('id', '!=', $recipe->id)
            ->whereHas('ingredients', function (Builder $query) use ($recipe) {
                $query->whereIn('ingredients.id', $recipe->ingredients->pluck('id'));
            })
            ->limit($limit)
            ->get();
    }

    private function getTopViewedRecipes(int $limit, array $excludeIds = []): Collection
    {
        return Recipe::query()
            ->when($excludeIds, function (Builder $query) use ($excludeIds) {
                return $query->whereNotIn('id', $excludeIds);
            })
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get();
    }
}
