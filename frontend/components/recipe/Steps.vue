<template>
    <div>
        <h3 class="sr-only">Steps</h3>

        <ul
            role="list"
            class="-mb-8 divide-y divide-gray-100"
        >
            <li
                v-for="(step, stepIdx) in steps"
                :key="step.id"
            >
                <div class="relative pb-8">
                    <span
                        v-if="stepIdx !== steps.length - 1"
                        class="absolute top-4 left-4 -ml-px h-full w-0.5"
                        aria-hidden="true"
                    />
                    <div class="relative flex space-x-3">
                        <div>
                            <span class="flex size-8 items-center justify-center rounded-full ring-8 ring-white">
                                {{ step.step_number }}
                            </span>
                        </div>
                        <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                            <div>
                                <p class="text-sm text-gray-500">
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
