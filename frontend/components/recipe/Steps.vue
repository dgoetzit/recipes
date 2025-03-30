<template>
    <div>
        <h3 class="sr-only">Steps</h3>

        <ul
            role="list"
            class="divide-y divide-gray-100 py-2"
        >
            <li
                v-for="(step, stepIdx) in steps"
                :key="step.id"
                class="rounded-lg transition-colors duration-150"
            >
                <div class="relative px-2 pt-4 pb-6">
                    <span
                        v-if="stepIdx !== steps.length - 1"
                        class="absolute top-8 left-4 -ml-px h-full w-0.5 bg-sky-100"
                        aria-hidden="true"
                    />
                    <div class="relative flex space-x-4">
                        <div>
                            <span
                                class="flex size-8 items-center justify-center rounded-full bg-sky-50 text-sm font-semibold text-sky-700 ring-4 ring-white"
                                :class="{ 'bg-sky-100': stepIdx === 0 }"
                            >
                                {{ step.step_number }}
                            </span>
                        </div>
                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                            <div>
                                <p class="text-sm leading-relaxed text-gray-700">
                                    {{ step.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
    const props = defineProps({
        steps: {
            type: Object,
            required: true,
        },
    });
</script>
