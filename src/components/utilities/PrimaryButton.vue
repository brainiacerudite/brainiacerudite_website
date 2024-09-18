<script lang="ts" setup>
const props = defineProps({
    link: Boolean,
    href: String,
})
</script>

<template>
    <a v-if="link" :href="href"
        class="mb-2 w-full text-center block px-7 py-3 uppercase border border-transparent border-solid transition-all duration-200 ease-in-out text-base font-semibold rounded text-dark-heading-color bg-light-primary-color hover:opacity-95 dark:text-dark-heading-color dark:bg-dark-primary-color lg:mb-0 lg:max-w-max">
        <slot />
    </a>
    <button v-else
        class="mb-2 w-full text-center block px-7 py-3 uppercase border border-transparent border-solid transition-all duration-200 ease-in-out text-base font-semibold rounded text-dark-heading-color bg-light-primary-color hover:opacity-95 dark:text-dark-heading-color dark:bg-dark-primary-color lg:mb-0 lg:max-w-max">
        <slot />
    </button>
</template>
