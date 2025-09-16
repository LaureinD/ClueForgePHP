<script setup>
    import { Link } from "@inertiajs/vue3"
    import Logo from "@/components/other/Logo.vue";
</script>

<template>
    <nav class="sticky top-0 z-999 w-full p-6 flex justify-between items-center shadow-lg shadow-background bg-surface">
        <div>
            <Logo :imageSize="30" textSize="text-2xl" href="home"></Logo>
        </div>

        <div class="flex gap-14">
            <div class="flex justify-around gap-12 text-lg">
                <Link :href="route('home')">Home</Link>
                <Link :href="route('whyClueForge')">Why ClueForge</Link>
                <Link :href="route('pricing')">Pricing</Link>
                <Link :href="route('help')">Help</Link>
                <Link :href="route('contact')">Contact</Link>
            </div>
            <div class="text-lg">
                <Link :href="route('auth.login')">Login</Link>
            </div>
        </div>
    </nav>
</template>
