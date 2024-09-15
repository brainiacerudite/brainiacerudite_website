<script setup lang="ts">

</script>

<template>
    <p
        class="pb-0.5 mb-4 relative uppercase font-semibold text-light-text-color after:content-[''] after:absolute after:top-full after:left-0 after:w-[60px] after:h-[2px] after:bg-light-text-color dark:text-dark-text-color dark:after:bg-dark-text-color lg:absolute lg:left-0 lg:top-0 lg:origin-left-top lg:mb-0 lg:after:top-[10px] lg:after:left-auto lg:after:right-[calc(100%+20px)] section-subtitle">
        <slot />
    </p>
</template>