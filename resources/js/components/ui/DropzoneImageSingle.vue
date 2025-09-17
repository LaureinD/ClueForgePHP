<script setup>
import {onBeforeUnmount, onMounted, ref} from "vue";

    const emit = defineEmits(["update:modelValue"])
    const props = defineProps({
        size: {
            type: Number,
            default: 40,
        },
        rounded: {
            type: String,
            default: null,
        },
        iconSize: {
            type: Number,
            default: 7,
        }
    });

    const preview = ref(null);
    const errorMessage = ref(null);

    onMounted(() => {
        const dropzone = document.querySelector('#dropzone');
        const input = document.querySelector('#imageInput');

        dropzone.addEventListener('click', function() {
            input.click();
        })

        dropzone.addEventListener('dragover', function(event) {
            event.preventDefault();
            event.stopPropagation();
        })

        dropzone.addEventListener('drop', function(event) {
            event.preventDefault();
            event.stopPropagation();
            handleDrop(event);
        })
    });

    onBeforeUnmount(() => {
        const dropzone = document.querySelector('#dropzone');
        const input = document.querySelector('#imageInput');

        dropzone.removeEventListener('click', function() {
            input.click();
        })

        dropzone.removeEventListener('dragover', function(event) {
            event.preventDefault();
            event.stopPropagation();
        })

        dropzone.addEventListener('drop', function(event) {
            event.preventDefault();
            event.stopPropagation();
            handleDrop(event);
        })
    })

    function handleDrop(event) {
        handleFile(event.dataTransfer.files[0]);
    }

    const handleChangeFile = (event) => {
        handleFile(event.target.files[0]);
    };

    function handleFile(file) {
        if (file && file.type.startsWith('image/')) {
            preview.value = URL.createObjectURL(file);
            emit('update:modelValue', file);
        }

        if (validateImage(file)) {
            emit('update:modelValue', file);
        }
    }

    function validateImage(image) {
        if (!image.type.startsWith('image/')) {
            errorMessage.value = 'Only images are accepted.'
            return false;
        } else if (image.size > 2 * 1024 * 1024) {
            errorMessage.value = 'File exceeds 2MB size limit.'
            return false;
        }

        return true;
    }

    const removeImage = () => {
        preview.value = null;
        errorMessage.value = null;
        emit('update:modelValue', null);
    }

</script>

<template>
    <div class="relative flex flex-col items-center">
        <div id="dropzone" :class="`h-${props.size} w-${props.size} rounded${props.rounded?'-'+props.rounded:''}`" class="flex items-center justify-center bg-background border border-secondary border-dashed text-secondary hover:cursor-pointer overflow-hidden">
            <div v-if="!preview" class="flex flex-col gap-y-4 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="`size-${props.iconSize}`">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v6m3-3H9m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                <p class="text-xs text-secondary">Upload image</p>
            </div>
            <img v-if="preview" :src="preview" :alt="preview" :class="`h-${props.size} w-${props.size} rounded${props.rounded?'-'+props.rounded:''}`" class="block object-cover">

        </div>
        <p v-if="errorMessage" class="text-danger text-sm my-2">{{ errorMessage }}</p>
        <button @click="removeImage" v-if="preview" class="absolute -right-1 -top-1 rounded-full text-danger bg-surface shadow-lg border border-background z-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        <input @change="handleChangeFile" id="imageInput" type="file" class="hidden">
    </div>
</template>
