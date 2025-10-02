<script setup>
    import {Link} from "@inertiajs/vue3";
    import Icon from "@/components/other/Icon.vue";

    const props = defineProps({
        paginator: {
            type: Object,
            required: true,
        },
        textLocation: {
            type: String,
            default: 'right',
            validator(value) {
                return ['top', 'bottom','left', 'right'].includes(value);
            }
        }
    })

    const textLocationClasses = {
        'top': 'flex-col gap-y-4',
        'bottom': 'flex-col flex-col-reverse gap-y-4',
        'left': 'gap-x-4',
        'right': 'flex-row-reverse gap-x-4'
    }
</script>

<template>
    <div
        class="flex justify-between"
        :class="[
            textLocationClasses[props.textLocation],
            $attrs['class'],
        ]"
    >
        <div class="flex items-center text-sm text-text-muted px-3">
            <p>Showing <span class="font-medium px-2">{{props.paginator.from}}</span> to <span class="font-medium px-2">{{props.paginator.to}}</span> of <span class="font-medium px-2">{{props.paginator.total}}</span> results.</p>
        </div>

        <div class="flex items-center text-lg rounded-lg overflow-hidden">
            <div
                v-for="link in props.paginator.links"
                :key="link.label"
            >
                <component
                    :is="link.url ? Link : 'span'"
                    :href="link.url"
                    class="size-12 flex items-center justify-center border"
                    :class="link.active
                        ? 'bg-accent-light border-accent'
                        : [
                            'bg-surface border-background',
                            link.url ? '' : 'text-text-muted hover:cursor-default'
                        ]"
                >
                    <Icon v-if="link.label.includes('Previous')" icon="chevronLeft" :size="5" />
                    <Icon v-else-if="link.label.includes('Next')" icon="chevronRight" :size="5" />
                    <span v-else>{{link.label}}</span>
                </component>
            </div>
        </div>
    </div>
</template>
