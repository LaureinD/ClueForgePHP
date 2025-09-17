<script setup>
    import Logo from "@/components/other/Logo.vue";
    import TextInput from "@/components/ui/TextInput.vue";
    import {Link, useForm} from '@inertiajs/vue3'
    import Button from "@/components/ui/Button.vue";
    import DropzoneSingleImage from "@/components/ui/DropzoneImageSingle.vue";

    const form = useForm({
        avatar: null,
        first_name: null,
        last_name: null,
        email: null,
        password: null,
        password_confirmation: null,
        acceptTerms: null,
    });

    const submitRegisterForm = () => {
        form.post(route('register'), {
            onError: () => form.reset('password', 'password_confirmation', 'acceptTerms')
        });
    };

</script>

<template>
    <Head>
        <title>Register</title>
    </Head>
    <div class="w-full py-12">
        <div class="w-full flex justify-center pb-3">
            <Logo :imageSize="64" :displayText="false" />
        </div>

        <div class="text-center flex flex-col gap-y-3 mb-10">
            <h1 class="text-2xl font-bold">Welcome to Clue<span class="text-accent">Forge</span>!</h1>
            <p>Sign up and start creating unique escape rooms!</p>
        </div>

        <button @click="console.log(form)">Log</button>

        <form @submit.prevent="submitRegisterForm" class="flex flex-col gap-y-4 max-w-lg mx-auto mb-20">
            <div class="flex flex-col items-center">
                <DropzoneSingleImage v-model="form.avatar" rounded="full" />
                <p v-if="form.errors.avatar" class="text-danger text-sm">{{ form.errors.avatar }}</p>
            </div>
<!--            CSRF protection included bij Inertia useform()-->
            <div class="grid grid-cols-2 gap-3">
                <TextInput v-model="form.first_name" name="First Name" type="text" autocomplete="given-name" required :message="form.errors.first_name" />
                <TextInput v-model="form.last_name" name="Last Name" type="text" autocomplete="family-name" required :message="form.errors.last_name" />
            </div>
            <TextInput v-model="form.email" name="Email" type="email" autocomplete="email" required :message="form.errors.email" />
            <div class="grid grid-cols-2 gap-3">
                <TextInput v-model="form.password" name="Password" type="password" autocomplete="new-password" required :message="form.errors.password" />
                <TextInput v-model="form.password_confirmation" name="Confirm password" type="password" autocomplete="new-password" required />
            </div>

            <div class="flex flex-col gap-1">
                <div class="flex gap-3">
                    <input v-model="form.acceptTerms" type="checkbox" id="acceptTerms" name="acceptTerms" class="border-secondary focus:outline-accent accent-accent">
<!--                    todo: Change terms link-->
                    <label for="acceptTerms"> I have read and accept the <Link :href="route('home')" class="text-accent font-semibold">Terms and conditions</Link>. <span class="text-sm align-text-top text-danger"> *</span> </label>
                </div>
                <p v-if="form.errors.acceptTerms" class="text-danger text-sm"> {{ form.errors.acceptTerms }} </p>
            </div>

            <div class="flex justify-between items-end mt-6">
                <Link :href="route('login')" class="text-center">Already have an account? <span class="text-accent">Log in.</span></Link>
                <Button type="submit" size="md" color="success" :disabled="form.processing"> {{ form.processing ? 'Registering' : 'Register' }} </Button>
            </div>
        </form>
    </div>
</template>
