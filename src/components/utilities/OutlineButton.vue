<script lang="ts" setup>
const props = defineProps({
    link: Boolean,
    href: String,
})
</script>

<template>
    <a v-if="link" :href="href"
        class="mb-2 w-full text-center block px-7 py-3 uppercase border border-light-heading-color border-solid transition-all duration-200 ease-in-out text-base font-semibold rounded text-light-heading-color hover:text-light-background-color hover:bg-light-heading-color dark:border-dark-heading-color dark:text-dark-heading-color dark:hover:text-dark-background-color dark:hover:bg-dark-heading-color lg:mb-0 lg:max-w-max">
        <slot />
    </a>
    <button v-else
        class="mb-2 w-full text-center block px-7 py-3 uppercase border border-light-heading-color border-solid transition-all duration-200 ease-in-out text-base font-semibold rounded text-light-heading-color hover:text-light-background-color hover:bg-light-heading-color dark:border-dark-heading-color dark:text-dark-heading-color dark:hover:text-dark-background-color dark:hover:bg-dark-heading-color lg:mb-0 lg:max-w-max">
        <slot />
    </button>
</template>
