<script setup>
    const model = defineModel(null); // bind aan id

    const props = defineProps({
        name: {
            type: String,
            required: true,
        },
        options: {
            type: Array,
            required: true, // [{ id: 1, value: '...' }, { id: 2, value: '...' }]
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
        <label :for="props.name" v-if="props.showLabel">
            {{ props.name }}
            <span v-if="props.required" class="text-sm align-text-top text-danger"> *</span>
        </label>

        <select
            v-model="model"
            :id="props.name"
            :name="props.name"
            :required="props.required"
            :class="`border rounded border-secondary py-2 px-3 focus:outline-accent ${$attrs.class}`"
        >
            <option value="" disabled hidden>{{ props.placeholder || 'Select...' }}</option>
            <option v-for="option in props.options" :key="option.id" :value="option.id">
                {{ option.value }}
            </option>
        </select>

        <p v-if="props.message" class="text-danger text-sm"> {{ props.message }} </p>
    </div>
</template>
