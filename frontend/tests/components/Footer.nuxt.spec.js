import { describe, it, expect } from 'vitest';
import { mountSuspended } from '@nuxt/test-utils/runtime';
import Footer from '~/components/Footer.vue';

describe('AppFooter', () => {
    it('renders the correct company name', async () => {
        const wrapper = await mountSuspended(Footer);
        expect(wrapper.text()).toContain('Recipe Search 3000, Inc.');
    });

    it('renders the current year', async () => {
        const wrapper = await mountSuspended(Footer);
        const currentYear = new Date().getFullYear().toString();
        expect(wrapper.text()).toContain(currentYear);
    });

    it('renders the complete copyright text correctly', async () => {
        const wrapper = await mountSuspended(Footer);
        const currentYear = new Date().getFullYear();
        const expectedText = `© ${currentYear} Recipe Search 3000, Inc.`;

        const textContent = wrapper.text().replace(/\s+/g, ' ').trim();
        expect(textContent).toContain(expectedText);
    });
});
