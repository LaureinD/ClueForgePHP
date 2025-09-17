<script setup>

import {
    ArrowPathIcon,
    InformationCircleIcon,
    UserGroupIcon,
    UserIcon,
    UserPlusIcon
} from "@heroicons/vue/24/outline/index.js";

    const props = defineProps({
        icon: {
            type: String,
            required: true,
        },
        size: {
            type: Number,
            default: 6,
        },
        boxSize: {
            type: Number,
            default: null,
        },
        rounded: {
            type: String,
            default: null,
        }
    })

    const icons = {
        'user': UserIcon,
        'userGroup': UserGroupIcon,
        'userPlus': UserPlusIcon,
        'arrowPath': ArrowPathIcon,
        'informationCircle': InformationCircleIcon,
    };
</script>

<template>
    <div v-if="icons[props.icon]" :class="`flex justify-center items-center ${props.boxSize ? `size-${props.boxSize}` : ''} rounded${props.rounded ? `-${props.rounded}`: ''} ${$attrs.class}`">
        <component :is="icons[props.icon]" :class="`size-${props.size}`"  />
    </div>
</template>
