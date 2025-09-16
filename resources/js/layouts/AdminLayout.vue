<script setup>
import NavBar from "@/components/backend/NavBar.vue";
</script>

<template>
    <div class="w-full min-h-screen bg-background flex justify-end">
        <NavBar />

        <main class="flex-grow h-screen overflow-hidden p-6">
            <slot />
        </main>
    </div>
</template>
