<template>
    <div>
        <Navigation />

        <NuxtPage />

        <Footer />
    </div>
</template>

<script setup>
    useHead({
        titleTemplate: (titleChunk) => {
            return titleChunk ? `${titleChunk} | Recipe Search 3000` : 'Recipe Search 3000';
        },
        meta: [
            { name: 'og:site_name', content: 'Recipe Search 3000' },
            { name: 'twitter:card', content: 'summary_large_image' },
        ],
    });
</script>
