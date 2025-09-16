<script setup>
import Logo from "@/components/other/Logo.vue";
import TextInput from "@/components/ui/TextInput.vue";
import {Link, useForm} from '@inertiajs/vue3'
import Button from "@/components/ui/Button.vue";

const form = useForm({
    email: null,
    password: null,
    rememberMe: null,
});

const submitLoginForm = () => {
    form.post(route('auth.login'), {
        onError: () => form.reset('password', 'rememberMe')
    });
};

</script>

<template>
    <Head>
        <title>Login</title>
    </Head>
    <div class="w-full py-12">
        <div class="w-full flex justify-center pb-3">
            <Logo :imageSize="64" :displayText="false" />
        </div>

        <div class="text-center flex flex-col gap-y-3 mb-10">
            <h1 class="text-2xl font-bold">Welcome to Clue<span class="text-accent">Forge</span>!</h1>
            <p>Log in and start creating unique escape rooms!</p>
        </div>

        <form @submit.prevent="submitLoginForm" class="flex flex-col gap-y-4 max-w-lg mx-auto my-20">
            <!--            CSRF protection included bij Inertia useform()-->
            <TextInput v-model="form.email" name="Email" type="email" autocomplete="email" required :message="form.errors.email" />
            <TextInput v-model="form.password" name="Password" type="password" autocomplete="new-password" required :message="form.errors.password" />

            <div class="flex flex-col gap-1">
                <div class="flex gap-3">
                    <input v-model="form.rememberMe" type="checkbox" id="rememberMe" name="rememberMe" class="border-secondary focus:outline-accent accent-accent">
                    <label for="rememberMe"> Remember me </label>
                </div>
            </div>

            <div class="flex justify-between items-end mt-6">
                <Link :href="route('auth.register')" class="text-center">Don't have an account yet? <span class="text-accent">Register here.</span></Link>
                <Button type="submit" size="md" color="success" :disabled="form.processing"> {{ form.processing ? 'Logging in' : 'Login' }} </Button>
            </div>
        </form>
    </div>
</template>
