<script setup>
    import { Link } from "@inertiajs/vue3"
    import Logo from "@/components/other/Logo.vue";
</script>

<template>
    <nav class="sticky top-0 z-999 w-full px-6 pt-7 pb-5 flex justify-between items-center shadow-lg shadow-background bg-surface">
        <div>
            <Logo :imageSize="30" textSize="text-2xl" href="home"></Logo>
        </div>

        <div class="flex gap-14">
            <div class="flex justify-around gap-12 text-lg">
                <Link :href="route('home')" class="border-b-4" :class="$page.component === 'frontend/Home' ? 'border-b-accent' : 'border-b-surface'">Home</Link>
                <Link :href="route('whyClueForge')" class="border-b-4" :class="$page.component === 'frontend/WhyClueForge' ? 'border-b-accent' : 'border-b-surface'">Why ClueForge</Link>
                <Link :href="route('pricing')" class="border-b-4" :class="$page.component === 'frontend/Pricing' ? 'border-b-accent' : 'border-b-surface'">Pricing</Link>
                <Link :href="route('help')" class="border-b-4" :class="$page.component === 'frontend/Help' ? 'border-b-accent' : 'border-b-surface'">Help</Link>
                <Link :href="route('contact')" class="border-b-4" :class="$page.component === 'frontend/Contact' ? 'border-b-accent' : 'border-b-surface'">Contact</Link>
                <Link :href="route('login')" class="border-b-4" :class="$page.component === 'frontend/auth/Login' ? 'border-b-accent' : 'border-b-surface'">Login</Link>
            </div>
        </div>
    </nav>
</template>
