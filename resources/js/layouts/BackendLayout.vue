<script setup>
import NavBarApp from "@/components/backend/NavBarApp.vue";
</script>

<template>
    <div class="w-full min-h-screen bg-background flex justify-end">
        <NavBarApp />

        <main class="flex-grow h-screen overflow-hidden p-6">
            <slot />
        </main>
    </div>
</template>
