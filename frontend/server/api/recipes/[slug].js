export default defineEventHandler(async (event) => {
    const slug = event.context.params.slug

    if (!slug) {
        return {
            error: true,
            message: 'Recipe slug is required',
            status: 400,
        }
    }

    try {
        const data = await $fetch(`http://localhost/api/recipes/${slug}`)

        return data
    }
    catch (error) {
        console.error(`Error fetching recipe with slug ${slug}:`, error)

        return {
            error: true,
            message: error.message || 'Failed to fetch recipe',
            status: error.status || 500,
        }
    }
})
