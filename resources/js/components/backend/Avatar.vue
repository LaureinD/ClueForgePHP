<script setup>
    import {sizeMap} from "@/utils/tailwindSizeMapping.js";

    const props = defineProps({
        path: {
            type: String,
            default: null,
        },
        alt: {
            type: String,
            default: 'user avatar'
        },
        size: {
            type: Number,
            default: 10
        },
        userFirstName: {
            type: String,
            default: '?'
        },
        fallBackTextSize: {
            type: String,
            default: 'text-xl'
        }
    })

    const bgColors = [
        'bg-primary',
        'bg-accent',
        'bg-success',
        'bg-warning',
        'bg-danger',
    ];
</script>

<template>
    <img v-if="props.path" :src="`/assets/${props.path}`" :alt="props.alt" :class="`${sizeMap[props.size]} rounded-full`">
    <div v-else :class="`${sizeMap[props.size]} size-10 rounded-full flex items-center justify-center text-surface ${bgColors[Math.floor(Math.random() * bgColors.length)]}`">
        <p :class="`${props.fallBackTextSize} uppercase font-semibold size-2 flex items-center justify-center`"> {{ props.userFirstName[0] }} </p>
    </div>
</template>
