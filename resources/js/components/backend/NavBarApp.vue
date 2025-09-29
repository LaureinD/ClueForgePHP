<script setup>
    import {ref} from "vue";
    import { Link } from '@inertiajs/vue3';
    import Button from "@/components/ui/Button.vue";
    import Logo from "@/components/other/Logo.vue";
    import Avatar from "@/components/backend/Avatar.vue";

    const userMenuOpen = ref(false);

</script>

<template>
    <nav class="sticky top-0 left-0 min-w-[185px] w-[calc(15vw)] 3xl:w-1/10 flex flex-col bg-surface h-screen shadow p-6">
        <Logo :imageSize="32" textsize="text-xl" href="admin.dashboard" />

        <div class="w-full flex flex-grow flex-col justify-between items-center">
            <div class="flex flex-col gap-3 items-center">
                <p>Home</p>
                <p>Riddles</p>
                <p>Escape rooms</p>
                <p>Library</p>
            </div>

            <div class="relative w-full">
                <div v-if="userMenuOpen" class="absolute bottom-full mb-1 w-full border border-background bg-surface overflow-hidden shadow">
                    <Link :href="route('logout')" method="post" as="button" class="w-full p-3 text-left flex gap-3 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                        Log out
                    </Link>
                </div>

                <Button @click="userMenuOpen = !userMenuOpen" type="button" color="surface" size="fit" class="w-full">
                    <div class="flex gap-3 px-4 py-2 items-center">
                        <Avatar :path="$page.props.auth.avatar?.path" :alt="$page.props.auth.avatar?.alt" :size="10" :userFirstName="$page.props.auth.user?.first_name" />
                        <p class="font-medium"> {{ $page.props.auth.user? `${$page.props.auth.user?.first_name} ${$page.props.auth.user?.last_name}` : 'Unknown' }} </p>
                    </div>
                </Button>
            </div>
        </div>
    </nav>
</template>
