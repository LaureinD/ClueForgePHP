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
    CheckCircleIcon,
    XCircleIcon,
    ExclamationTriangleIcon,
    TrashIcon,
    PencilSquareIcon,
    PlusIcon,
} from "@heroicons/vue/24/outline/index.js";
import {
    CheckCircleIcon as CheckCircleIconSolid,
    XCircleIcon as XCircleIconSolid,
    ExclamationTriangleIcon as ExclamationTriangleIconSolid,
    InformationCircleIcon as InformationCircleIconSolid,
} from "@heroicons/vue/24/solid/index.js";
import {sizeMap, strokeMap} from "@/utils/tailwindSizeMapping.js";

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
        },
        strokeWidth: {
            type: [Number, String],
            default: 1.5
        }
    })

    const icons = {
        'user': UserIcon,
        'userGroup': UserGroupIcon,
        'userPlus': UserPlusIcon,
        'arrowPath': ArrowPathIcon,
        'informationCircle': InformationCircleIcon,
        'informationCircleSolid': InformationCircleIconSolid,
        'rectangleGroup': RectangleGroupIcon,
        'chevronLeft': ChevronLeftIcon,
        'chevronRight': ChevronRightIcon,
        'chevronUp': ChevronUpIcon,
        'chevronDown': ChevronDownIcon,
        'check': CheckIcon,
        'checkCircle': CheckCircleIcon,
        'checkCircleSolid': CheckCircleIconSolid,
        'x': XMarkIcon,
        'xCircle': XCircleIcon,
        'xCircleSolid': XCircleIconSolid,
        'warning': ExclamationTriangleIcon,
        'warningSolid': ExclamationTriangleIconSolid,
        'trash': TrashIcon,
        'pencilSquare': PencilSquareIcon,
        'plus': PlusIcon,
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
        <component
            :is="icons[props.icon]"
            :class="[
                props.size ? sizeMap[props.size] : '',
                strokeMap[props.strokeWidth],
            ]"
        />
    </div>
</template>
