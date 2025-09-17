<script setup>
import Button from "@/components/ui/Button.vue";
import {Link} from '@inertiajs/vue3';
</script>

<template>
    <Head>
        <title>Home</title>
    </Head>

    <div class="p-6">
        <div class="w-1/2 mx-auto min-h-[50vh] flex justify-center items-center flex-col gap-6 text-center">
            <h1 class="text-6xl leading-20">What will you <br> <span class="text-accent">Create</span> today? </h1>
            <h2 class="text-2xl leading-10">Design your own puzzles, rooms and stories. <br> Let players escape your
                imagination.</h2>

            <div class="p-12 flex flex-col gap-6">
                <Button type="link" href="pricing" size="md" color="success">
                    Get ClueForge for free!
                </Button>

                <Link :href="route('login')">Already have an account? <span class="text-accent">Log In</span>.</Link>
            </div>
        </div>

        <div class="grid grid-cols-4 gap-6">
            <div class="p-6 flex flex-col align-center items-center justify-center">
                <div class="relative bg-brush-primary w-full p-6 m-6 aspect-square">
                    <div class="absolute top-5 right-8 p-3  rounded-full bg-white flex justify-center items-center text-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-20">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 0 0 2.25-2.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v2.25A2.25 2.25 0 0 0 6 10.5Zm0 9.75h2.25A2.25 2.25 0 0 0 10.5 18v-2.25a2.25 2.25 0 0 0-2.25-2.25H6a2.25 2.25 0 0 0-2.25 2.25V18A2.25 2.25 0 0 0 6 20.25Zm9.75-9.75H18a2.25 2.25 0 0 0 2.25-2.25V6A2.25 2.25 0 0 0 18 3.75h-2.25A2.25 2.25 0 0 0 13.5 6v2.25a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </div>
                </div>

                <h3 class="text-xl font-semibold my-6">Build without limits</h3>
                <p>Create puzzles and escape rooms directly in your browser — no installs, no fuss.</p>
            </div>

            <div class="p-6 flex flex-col align-center items-center justify-center">
                <div class="relative bg-brush-success w-full p-6 m-6 aspect-square">
                    <div class="absolute top-5 right-8 p-3  rounded-full bg-white flex justify-center items-center text-success">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor" class="size-20">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/>
                        </svg>
                    </div>
                </div>

                <h3 class="text-xl font-semibold my-6">Create smarter riddles</h3>
                <p>Combine text, logic, media, and triggers to craft unique challenges your players won’t forget.</p>
            </div>

            <div class="p-6 flex flex-col align-center items-center justify-center">
                <div class="relative bg-brush-warning w-full p-6 m-6 aspect-square">
                    <div class="absolute top-5 right-8 p-3  rounded-full bg-white flex justify-center items-center text-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor" class="size-20">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z"/>
                        </svg>
                    </div>
                </div>

                <h3 class="text-xl font-semibold my-6">Share your creations</h3>
                <p>Invite friends or players with a link. Let others explore, test, and enjoy your escape room.</p>
            </div>

            <div class="p-6 flex flex-col align-center items-center justify-center">
                <div class="relative bg-brush-danger w-full p-6 m-6 aspect-square">
                    <div class="absolute top-5 right-8 p-3  rounded-full bg-white flex justify-center items-center text-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5"
                             stroke="currentColor" class="size-20">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z"/>
                        </svg>
                    </div>
                </div>

                <h3 class="text-xl font-semibold my-6">Organize your toolkit</h3>
                <p>Bundle clues, images, props, and notes in one place for each room or scenario you design.</p>
            </div>
        </div>
    </div>
</template>
