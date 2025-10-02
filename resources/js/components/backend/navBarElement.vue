<script setup>
    import {Link} from "@inertiajs/vue3";
    import Icon from "@/components/other/Icon.vue";

    const props = defineProps({
        routeName: {
            type: String,
            required: true,
        },
        pageName: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: true,
        },
        iconName: {
            type: String,
            required: true,
        },
        iconSize: {
            type: Number,
            default: 7
        },
    })
</script>

<template>
    <Link :href="route($props.routeName)" :class="$page.component === $props.pageName ? 'border-b-accent' : 'border-b-surface'" class="w-full flex justify-between items-center border-b-4 py-2">
        <div class="flex gap-3 items-center">
            <Icon :icon="$props.iconName" :size="$props.iconSize" :stroke-width="1.2" />
            <p class="text-lg">{{ props.label }}</p>
        </div>
        <Icon icon="chevronRight" :size="4" />
    </Link>
</template>
