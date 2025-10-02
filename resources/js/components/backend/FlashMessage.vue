<script setup>
import {computed, ref, watch} from 'vue';
import {usePage} from '@inertiajs/vue3';
import Icon from "@/components/other/Icon.vue";

const page = usePage();
const messages = ref([]);

const showMessage = (type, message, autoclose = true, duration = 5000) => {
    const id = Date.now() + Math.random();
    messages.value.push({
        id,
        type,
        message,
        autoclose,
        duration,
    });

    if (autoclose) {
        setTimeout(() => {
            messages.value = messages.value.filter(message => message.id !== id);
        }, duration);
    }
}

watch(
    () => page.props.flash,
    (flash) => {
        if (!flash) return;

        ['success', 'error', 'warning', 'info'].forEach(type => {
            if (flash[type]) {
                const items = Array.isArray(flash[type]) ? flash[type] : [flash[type]];

                items.forEach(item => {
                    if (typeof item === 'string') {
                        showMessage(type, item);
                    } else {
                        showMessage(type, item.message, item.autoClose ?? true, item.duration ?? 5000)
                    }
                })
            }
        });
    },
    {deep: true, immediate: true}
);

const closeMessage = (id) => {
    messages.value = messages.value.filter(message => message.id !== id);
}
</script>

<template>
    <div class="fixed bottom-4 right-4 z-999 flex flex-col gap-2">
        <transition-group
            name="flashMessage"
            tag="div"
            enter-active-class="transition ease-out duration-300"
            leave-active-class="transition ease-in duration-200"
        >
            <div
                v-for="message in messages"
                :key="message.id"
                class="max-w-sm w-full text-text-primary border shadow-lg rounded-lg pointer-events-auto whitespace-pre-line mt-1.5"
                :class="[
                    message.type === 'success' && 'bg-success-light border-success',
                    message.type === 'error' && 'bg-danger-light border-danger',
                    message.type === 'warning' && 'bg-warning-light border-warning',
                    message.type === 'info' && 'bg-primary-light border-primary'
                ]"
            >
                <div class="flex p-4">
                    <div class="flex-shrink-0">
                        <Icon v-if="message.type === 'success'" icon="checkCircleSolid" :size="5" class="text-success" />
                        <Icon v-if="message.type === 'error'" icon="xCircleSolid" :size="5" class="text-danger" />
                        <Icon v-if="message.type === 'warning'" icon="warningSolid" :size="5" class="text-warning" />
                        <Icon v-if="message.type === 'info'" icon="informationCircleSolid" :size="5" class="text-primary" />
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium">{{ message.message }}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex h-full items-start">
                        <button @click="closeMessage(message.id)" class="inline-flex">
                            <span class="sr-only">Close</span>
                            <Icon icon="x" :size="5" />
                        </button>
                    </div>
                </div>
            </div>
        </transition-group>
    </div>
</template>

