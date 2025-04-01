import { describe, it, expect } from 'vitest';
import { mountSuspended } from '@nuxt/test-utils/runtime';
import Card from '~/components/recipe/Card.vue';

describe('Recipe Card', () => {
    const mockRecipe = {
        name: 'Delicious Pasta',
        email: 'chef@example.com',
        slug: 'delicious-pasta',
        image: '/images/pasta.jpg',
        image_alt: 'A plate of pasta',
        rating: 4,
        reviews: 42,
        views: 1500,
        published_at: '2023-04-15T12:00:00Z',
    };

    it('renders recipe name correctly', async () => {
        const wrapper = await mountSuspended(Card, {
            props: {
                recipe: mockRecipe,
            },
        });

        expect(wrapper.text()).toContain('Delicious Pasta');
    });

    it('renders author email correctly', async () => {
        const wrapper = await mountSuspended(Card, {
            props: {
                recipe: mockRecipe,
            },
        });

        expect(wrapper.text()).toContain('By: chef@example.com');
    });

    it('formats views correctly with K suffix for thousands', async () => {
        const wrapper = await mountSuspended(Card, {
            props: {
                recipe: mockRecipe,
            },
        });

        expect(wrapper.text()).toContain('1.5K');
    });

    it('formats small view count without K suffix', async () => {
        const smallViewRecipe = { ...mockRecipe, views: 999 };
        const wrapper = await mountSuspended(Card, {
            props: {
                recipe: smallViewRecipe,
            },
        });

        expect(wrapper.text()).toContain('999');
    });

    it('formats date correctly', async () => {
        const wrapper = await mountSuspended(Card, {
            props: {
                recipe: mockRecipe,
            },
        });

        expect(wrapper.text()).toContain('Apr 15');
    });

    it('displays the review count correctly', async () => {
        const wrapper = await mountSuspended(Card, {
            props: {
                recipe: mockRecipe,
            },
        });

        expect(wrapper.text()).toContain('42');
    });

    it('links to the correct recipe detail page', async () => {
        const wrapper = await mountSuspended(Card, {
            props: {
                recipe: mockRecipe,
            },
        });

        const link = wrapper.find('a');
        expect(link.attributes('href')).toContain('/recipes/delicious-pasta');
    });
});
