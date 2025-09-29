<script setup>
    import Icon from "@/components/other/Icon.vue";
    import {nextTick, onBeforeUnmount, onMounted, ref} from "vue";
    import {createPopper} from "@popperjs/core";
    import CustomTooltip from "@/components/other/CustomTooltip.vue";

    const props = defineProps({
        title: {
            type: String,
            required: true,
        },
        value: {
            type: [String, Number],
            required: true,
        },
        unit: {
            type: String,
            default: null
        },
        tooltip: {
            type: String,
            default: null,
        },
        icon: {
            type: String,
            default: null,
        },
        iconSize: {
            type: Number,
            default: 6,
        },
        iconBoxSize: {
            type: Number,
            default: 8,
        },
        color: {
            type: String,
            default: 'surface',
            validator(value) {
                return [
                    'primary',
                    'secondary',
                    'accent',
                    'background',
                    'surface',
                    'success',
                    'warning',
                    'danger',
                ].includes(value);
            }
        },
    })

    const colorClasses = {
        'primary': 'bg-primary-light text-primary',
        'secondary': 'bg-secondary-light text-secondary',
        'accent': 'bg-accent-light text-accent',
        'background': 'bg-background-light text-background',
        'surface': 'bg-surface text-text-primary',
        'success': 'bg-success-light text-success',
        'warning': 'bg-warning-light text-warning',
        'danger': 'bg-danger-light text-danger',
    }

    const infoIcon = ref(null);
    const tooltip = ref(null);
    let popperInstance = null;

    onMounted(async () => {
        if (props.tooltip) {
            await nextTick();

            if (infoIcon.value && tooltip.value) {
                popperInstance = createPopper(infoIcon.value, tooltip.value, {
                    placement: "bottom",
                    modifiers: [
                        { name: "offset", options: { offset: [0,8] } },
                        { name: "preventOverflow", options: { boundary: "viewport" } },
                        { name: "flip" }
                    ]
                })
            }
        }
    });

    onBeforeUnmount(() => {
        if (popperInstance) {
            popperInstance.destroy();
            popperInstance = null;
        }
    })

</script>

<template>
    <div :class="`rounded shadow-xl p-6 bg-white border-background flex items-center ${$attrs.class}`">
        <Icon v-if="props.icon" :icon="props.icon" :boxSize="props.iconBoxSize" :size="props.iconSize" rounded :class="props.color ? colorClasses[color] :  colorClasses['surface']" />

        <div class="flex-grow flex flex-col text-right">
            <p class="text-xl font-semibold my-1">
                {{
                    (typeof props.value === 'number'
                        ? new Intl.NumberFormat('nl-BE').format(value)
                        : value)
                    + (props.unit ? ` ${props.unit}` : '')

                }}
            </p>

            <div class="flex gap-3 w-full justify-end items-center text-text-muted">
                <p> {{ props.title }} </p>
                <CustomTooltip :content="props.tooltip" placement="bottom">
                    <template #trigger>
                        <Icon icon="informationCircle" :size="5" class="text-text-muted" ref="infoIcon" />
                    </template>
                </CustomTooltip>
            </div>
        </div>
    </div>
</template>
