export default defineEventHandler(async (event) => {
    const query = getQuery(event);

    const url = new URL('http://localhost/api/recipes');

    for (const [key, value] of Object.entries(query)) {
        if (value) {
            url.searchParams.append(key, value);
        }
    }

    try {
        const data = await $fetch(url.toString());

        return data;
    } catch (error) {
        console.error('Error fetching recipes from Laravel:', error);

        return {
            error: true,
            message: error.message,
            status: error.status || 500,
        };
    }
});
