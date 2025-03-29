// server/api/recipes.js
export default defineEventHandler(async (event) => {
    // Get query parameters from the request
    const query = getQuery(event);

    // Construct the URL with query parameters
    const url = new URL('http://localhost/api/recipes');

    // Add any query parameters that exist
    if (query.email) url.searchParams.append('email', query.email);
    if (query.keyword) url.searchParams.append('keyword', query.keyword);
    if (query.ingredient) url.searchParams.append('ingredient', query.ingredient);

    console.log('Fetching from Laravel:', url.toString());

    try {
        // Make the request to Laravel with query parameters
        const data = await $fetch(url.toString());
        return data;
    } catch (error) {
        console.error('Error fetching recipes from Laravel:', error);

        // Return a structured error response
        return {
            error: true,
            message: error.message,
            status: error.status || 500,
        };
    }
});
