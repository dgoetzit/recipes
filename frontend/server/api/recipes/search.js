export default defineEventHandler(async (event) => {
    try {
        const query = getQuery(event);
        const searchQuery = query.q || '';

        const response = await $fetch('http://localhost/api/recipes/search', {
            method: 'GET',
            headers: {
                Accept: 'application/json',
            },
            params: {
                q: searchQuery,
            },
        });

        if (response && response.success) {
            return {
                data: response.data,
            };
        } else {
            throw new Error(response.message || 'Error in search response');
        }
    } catch (error) {
        console.error('Error searching recipes:', error);

        return {
            error: true,
            message: error.message || 'Failed to search recipes',
            status: error.status || 500,
            data: [],
        };
    }
});
