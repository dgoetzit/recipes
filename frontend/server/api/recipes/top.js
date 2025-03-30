export default defineEventHandler(async (event) => {
    try {
        const data = await $fetch('http://localhost/api/recipes/top', {
            method: 'GET',
            headers: {
                Accept: 'application/json',
            },
        });

        return {
            data: data,
        };
    } catch (error) {
        console.error('Error fetching top recipes:', error);

        return {
            error: true,
            message: error.message || 'Failed to fetch top recipes',
            status: error.status || 500,
        };
    }
});
