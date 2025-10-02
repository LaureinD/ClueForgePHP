<script setup>

    const model = defineModel({
        type: null,
        required: true
    });

    const props = defineProps({
        type: {
            type: String,
            required: true,
            default: 'text',
            validator(value) {
                return ['text', 'email', 'password', 'search'].includes(value);
            }
        },
        name: {
            type: String,
            required: true,
        },
        autocomplete: {
            type: String,
        },
        required: {
            type: Boolean,
            default: false
        },
        message: {
            type: String,
            default: null,
        },
        showLabel: {
            type: Boolean,
            default: true
        },
        placeholder: {
            type: String,
            default: null,
        },
    })
</script>

<template>
    <div class="flex flex-col gap-1" :class="$attrs['class']">
        <label :for="props.name" v-if="props.showLabel"> {{ props.name }} <span v-if="props.required" class="text-sm align-text-top text-danger"> *</span> </label>
        <input
            v-model="model"
            :type="props.type"
            :id="props.name"
            :name="props.name"
            :autocomplete="props.autocomplete"
            :placeholder="props.placeholder"
            :required="props.required"
            :class="`border rounded border-secondary py-2 px-3 focus:outline-accent ${$attrs.class}`"
        >
        <p v-if="props.message" class="text-danger text-sm"> {{ props.message }} </p>
    </div>
</template>
