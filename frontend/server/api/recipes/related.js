export default defineEventHandler(async (event) => {
    try {
        const query = getQuery(event)
        const searchQuery = query.id || null

        const data = await $fetch('http://localhost/api/recipes/related', {
            method: 'GET',
            headers: { Accept: 'application/json' },
            params: { id: searchQuery },
        })

        return { data }
    }
    catch (error) {
        console.error('Error fetching related recipes:', error)

        return {
            error: true,
            message: error && error.message ? error.message : 'Failed to fetch related recipes',
            status: error && error.status ? error.status : 500,
        }
    }
})
