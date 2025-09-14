<script setup lang="ts">
import NavBar from "@/components/frontend/NavBar.vue";
import Footer from "@/components/frontend/Footer.vue";
</script>

<template>
    <div class="w-full min-h-screen bg-background font-wix">
        <div id="wrapper" class="bg-surface w-[1320px] mx-auto min-h-screen flex flex-col">

            <NavBar />

            <main>
                <slot />
            </main>

            <Footer />

        </div>
    </div>
</template>
