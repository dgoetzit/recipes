<template>
    <div>
        <h3 class="sr-only">Steps</h3>

        <ul
            role="list"
            class="relative"
        >
            <li
                v-for="(step, stepIdx) in steps"
                :key="step.id"
                class="relative pb-8"
                :class="{ 'pb-0': stepIdx === steps.length - 1 }"
            >
                <div
                    v-if="stepIdx !== steps.length - 1"
                    class="absolute top-8 left-4 -ml-px h-full w-0.5 bg-green-100"
                    aria-hidden="true"
                />

                <div class="flex items-start">
                    <div class="relative z-10 flex-shrink-0">
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-full bg-green-50 text-sm font-semibold text-green-700 ring-4 ring-white"
                            :class="{ 'bg-green-100': stepIdx === 0 }"
                        >
                            {{ step.step_number }}
                        </span>
                    </div>

                    <div class="ml-4 flex-1">
                        <p class="mt-0.5 text-sm leading-relaxed text-gray-700">
                            {{ step.description }}
                        </p>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script setup>
    defineProps({
        steps: {
            type: Object,
            required: true,
        },
    });
</script>
