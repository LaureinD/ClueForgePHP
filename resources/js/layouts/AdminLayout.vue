<script setup>
import NavBarAdmin from "@/components/backend/NavBarAdmin.vue";
import FlashMessage from "@/components/backend/FlashMessage.vue";
</script>

<template>
    <div class="w-full min-h-screen bg-background flex justify-end">
        <NavBarAdmin />

        <main class="flex-grow h-screen overflow-hidden p-6">
            <slot />
        </main>

        <FlashMessage />
    </div>
</template>
