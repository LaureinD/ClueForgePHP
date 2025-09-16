<script setup>
    import { Link } from '@inertiajs/vue3'

    const props = defineProps({
        type: {
            type: String,
            default: 'button',
            required: true,
            validator(value) {
                return ['button', 'submit', 'reset', 'link'].includes(value);
            }
        },
        size: {
            type: String,
            default: 'md',
            validator(value) {
                return ['sm', 'md', 'lg', 'xl', 'full', 'fit'].includes(value);
            }
        },
        color: {
            type: String,
            default: 'surface',
            validator(value) {
                return ['primary', 'secondary', 'accent', 'background', 'surface', 'success', 'warning', 'danger'].includes(value);
            }
        },
        href: {
            type: String,
            default: null,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    });

    const baseClasses = 'rounded hover:cursor-pointer disabled:bg-background disabled:text-text-muted disabled:cursor-not-allowed'

    const colorClasses = {
        'primary': 'bg-primary text-white',
        'secondary': 'bg-secondary text-text-primary',
        'accent': 'bg-accent text-white',
        'background': 'bg-background text-text-primary',
        'surface': 'bg-surface text-text-primary border border-background',
        'success': 'bg-success text-white',
        'warning': 'bg-warning text-text-primary',
        'danger': 'bg-danger text-white',
    };

    const sizeClasses = {
        'sm': 'py-2 px-4 text-sm w-fit',
        'md': 'py-4 px-8 font-medium w-fit',
        'lg': 'py-5 px-12 text-lg font-medium w-fit',
        'xl': 'py-6 px-16 text-xl font-semibold w-fit',
        'full': 'w-full py-4',
        'fit' : 'w-fit '
    }

    const buttonClasses = `${baseClasses} ${ colorClasses[props.color] } ${ sizeClasses[props.size] }`;

    if (props.type === 'link' && !props.href) {
        console.warn('Prop "href" is required when custom button type is "link".');
    }
    if (props.type !== "link" && props.href) {
        console.warn('Prop "href" can only be used when custom button type is "link".');
    }

</script>

<template>
    <Link
        v-if="props.type === 'link'"
        :href="route(props.href)"
        :class="[buttonClasses, $attrs.class]"
    >
        <slot />
    </Link>

    <button
        v-else
        :type="props.type"
        :disabled="props.disabled"
        :class="[buttonClasses, $attrs.class]"
    >
        <slot />
    </button>
</template>
