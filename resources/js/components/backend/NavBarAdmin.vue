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
            <div class="w-full flex flex-col gap-8 items-center py-8">
                <Link :href="route('admin.dashboard')" :class="$page.component === 'admin/Dashboard' ? 'border-b-accent' : 'border-b-surface'" class="w-full flex justify-between items-center border-b-4 py-2">
                    <div class="flex gap-3 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 7.125C2.25 6.504 2.754 6 3.375 6h6c.621 0 1.125.504 1.125 1.125v3.75c0 .621-.504 1.125-1.125 1.125h-6a1.125 1.125 0 0 1-1.125-1.125v-3.75ZM14.25 8.625c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v8.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-8.25ZM3.75 16.125c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125v2.25c0 .621-.504 1.125-1.125 1.125h-5.25a1.125 1.125 0 0 1-1.125-1.125v-2.25Z" />
                        </svg>

                        <p class="text-lg">Dashboard</p>
                    </div>
                    <svg v-if="$page.component === 'admin/Dashboard'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </Link>

                <Link :href="route('users.index')" :class="$page.component === 'admin/users/Index' ? 'border-b-accent' : 'border-b-surface'" class="w-full flex justify-between items-center border-b-4 py-2">
                    <div class="flex gap-3 items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="size-7">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>

                        <p class="text-lg">Users</p>
                    </div>
                    <svg v-if="$page.component === 'admin/users/Index'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </Link>
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
                        <Avatar />
                        <p class="font-medium"> {{ $page.props.auth.user? `${$page.props.auth.user?.first_name} ${$page.props.auth.user?.last_name}` : 'Unknown' }} </p>
                    </div>
                </Button>
            </div>
        </div>
    </nav>
</template>
