<script setup>

import {
    ArrowPathIcon,
    InformationCircleIcon,
    UserGroupIcon,
    UserIcon,
    UserPlusIcon,
    RectangleGroupIcon,
    ChevronLeftIcon,
    ChevronRightIcon,
    ChevronUpIcon,
    ChevronDownIcon,
    CheckIcon,
    XMarkIcon,
} from "@heroicons/vue/24/outline/index.js";
import {sizeMap} from "@/utils/tailwindSizeMapping.js";

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
        'rectangleGroup': RectangleGroupIcon,
        'chevronLeft': ChevronLeftIcon,
        'chevronRight': ChevronRightIcon,
        'chevronUp': ChevronUpIcon,
        'chevronDown': ChevronDownIcon,
        'check': CheckIcon,
        'x': XMarkIcon,
    };

</script>

<template>
    <div
        v-if="icons[props.icon]"
        :class="[
            'flex justify-center items-center',
            props.boxSize ? sizeMap[props.boxSize] : '',
            props.rounded ? `rounded-${props.rounded}` : '',
            $attrs.class
        ]"
    >
        <component :is="icons[props.icon]" :class="props.size ? sizeMap[props.size] : ''" />
    </div>
</template>
