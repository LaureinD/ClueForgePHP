<script setup>
    import Icon from "@/components/other/Icon.vue";

    const props = defineProps({
        title: {
            type: String,
            required: true,
        }
    })
    const emits = defineEmits([
        'closeModal'
    ])

    const closeModal = () => {
        emits('closeModal');
    }
</script>

<template>
    <div @click="closeModal" class="fixed inset-0 bg-black bg-opacity-40 z-50 backdrop-blur-sm flex justify-center items-center">
        <div @click.stop class="w-2/3 max-w-2xl max-h-[90vh] overflow-y-auto overflow-x-hidden bg-surface rounded-lg shadow-lg p-6">
            <div class="flex justify-between mb-6">
                <p class="text-xl"> {{ props.title }} </p>
                <button @click="closeModal">
                    <Icon icon="x" :size="5" />
                </button>
            </div>

            <slot />
        </div>
    </div>
</template>
