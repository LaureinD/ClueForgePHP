<script setup>
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        imageSize: {
            type: Number,
            default: 48,
        },
        textSize: {
            type: String,
            default: 'text-2xl',
        },
        href: {
            type: String,
            default: null,
        },
        displayText: {
            type: Boolean,
            default: true,
        }
    })

    const textClasses = `font-bold ${props.textSize}`;
    const componentType = props.href ? Link : 'div';
    const componentAttributes = props.href ? { href: route(props.href) } : {};

</script>

<template>
    <component
        :is="componentType"
        v-bind="componentAttributes"
        class="flex gap-2 items-center"
    >
        <img
            :src="'/assets/img/logos/Clueforge.png'"
            alt="ClueForge logo"
            :width="props.imageSize"
            :height="props.imageSize"
        >

        <p
            v-if="props.displayText"
            :class="textClasses"
        >
            Clue<span class="text-accent">Forge</span>
        </p>
    </component>

</template>
