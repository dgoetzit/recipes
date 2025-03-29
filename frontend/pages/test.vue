<template></template>

<script setup>
    const { data } = await useFetch('/api/recipes');

    console.log('data', data);
</script>
