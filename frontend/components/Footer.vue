<template>
    <footer aria-labelledby="footer-heading" class="bg-white">
        <h2 id="footer-heading" class="sr-only">Footer</h2>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="border-t border-gray-100 py-10 w-full justify-center flex items-center"
            >
                <p class="mt-6 text-center text-sm text-gray-500 sm:mt-0">
                    &copy; {{ year }} Recipe Search 3000, Inc.
                </p>
            </div>
        </div>
    </footer>
</template>

<script setup>
const year = new Date().getFullYear();
</script>
