<script setup>
    import Icon from "@/components/other/Icon.vue";

    const props = defineProps({
        title: {
            type: String,
            required: true,
        },
        value: {
            type: [String, Number],
            required: true,
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

</script>

<template>
    <div :class="`rounded shadow-xl p-6 bg-white border-background flex items-center ${$attrs.class}`">
        <Icon v-if="props.icon" :icon="props.icon" :boxSize="props.iconBoxSize" :size="props.iconSize" rounded :class="props.color ? colorClasses[color] :  colorClasses['surface']" />

        <div class="flex-grow flex flex-col text-right">
            <p class="text-xl font-semibold my-1">
                {{
                    typeof props.value === 'number'
                        ? new Intl.NumberFormat('nl-BE').format(value)
                        : value
                }}
            </p>

            <div class="flex gap-3 w-full justify-end items-center text-text-muted">
                <p> {{ props.title }} </p>
                <div v-if="props.tooltip" class="relative group size-5">
                    <Icon icon="informationCircle" :size="6" class="text-text-muted" />
                    <div class="absolute top-full left-0 z-50 w-32 p-3 shadow-xl rounded overflow-hidden hidden group-hover:block text-left bg-background whitespace-normal mt-1">
                        <p class="text-xs text-text-primary"> {{ props.tooltip }} </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
