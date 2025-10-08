<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from "vue";
import { createPopper } from "@popperjs/core";

const props = defineProps({
    content: {
      type: String,
      default: null
    },
    placement: {
      type: String,
      default: "top"
    },
    offset: {
      type: Array,
      default: () => [0, 8]
    }
});

const trigger = ref<HTMLElement | null>(null);
const tooltip = ref<HTMLElement | null>(null);
let popperInstance: any = null;
const isVisible = ref(false);

onMounted(() => {
    if (trigger.value && tooltip.value) {
        popperInstance = createPopper(trigger.value, tooltip.value, {
            placement: props.placement,
            modifiers: [
                { name: "offset", options: { offset: props.offset } },
                { name: "preventOverflow", options: { boundary: "viewport" } },
                { name: "flip" }
            ]
        });
    }
});

onBeforeUnmount(() => {
    if (popperInstance) {
        popperInstance.destroy();
        popperInstance = null;
    }
});

function show() {
    isVisible.value = true;
    popperInstance?.update();
}

function hide() {
    isVisible.value = false;
}
</script>

<template>
    <div class="relative inline-block" @mouseenter="show" @mouseleave="hide">
        <div ref="trigger">
            <slot name="trigger"></slot>
        </div>

        <div
            ref="tooltip"
            v-show="isVisible"
            class="min-w-32 z-50 p-3 bg-background text-xs rounded shadow-xl whitespace-normal max-w-xs overflow-hidden text-left border-2 border-surface"
        >
            <slot name="content">
                {{ props.content }}
            </slot>
        </div>
    </div>
</template>
