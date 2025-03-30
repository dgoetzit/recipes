<template>
    <div>
        <div class="mb-4 inline-flex h-16 w-16 items-center justify-center rounded-full bg-red-100">
            <span class="text-red-600">!</span>
        </div>
        <h3 class="text-lg font-medium text-gray-900">Error loading recipes</h3>
        <p class="mt-2 text-sm text-gray-500">Please try again later or refine your search.</p>
        <button
            @click="fetchRecipes(1)"
            class="mt-4 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700"
        >
            Try Again
        </button>
    </div>
</template>

<script setup></script>
