<script setup>
    import TextInput from "@/components/ui/TextInput.vue";
    import {useForm} from '@inertiajs/vue3'
    import Button from "@/components/ui/Button.vue";
    import DropzoneSingleImage from "@/components/ui/DropzoneImageSingle.vue";
    import {ucFirst} from "../../../utils/textHelper.js";
    import {onBeforeMount, ref, watch} from "vue";
    import Icon from "@/components/other/Icon.vue";
    import CustomTooltip from "@/components/other/CustomTooltip.vue";

    const props = defineProps({
        roles: {
            type: Array,
            required: true,
        },
        permissionCategories: {
            type: Array,
            required: true,
        },
        user: {
            type: Object,
            default: null,
        }
    });
    const emits = defineEmits([
        'closeModal',
    ])

    const form = useForm({
        avatar: null,
        first_name: null,
        last_name: null,
        email: null,
        password: null,
        password_confirmation: null,
        selectedRoles: [],
    });
    let action = 'create';
    const showCategory = ref(null);

    watch(() => form.selectedRoles, (value) => {
        if (value.includes('user') && value.length > 1) {
            form.selectedRoles = ['user'];
        }

    }, {deep: true})

    const handleSubmit = () => {
        if (action === 'create') {
            submitCreateForm();
        } else {
            submitEditForm();
        }
    }
    const submitCreateForm = () => {
        form.post(route('users.create'), {
            onError: () => form.reset('password', 'password_confirmation'),
            onSuccess: () => {
                emits('closeModal');
                form.reset();
            },
        });
    };
    const submitEditForm = () => {
        form.post(route('users.update', [props.user.id]), {
            onError: () => form.reset('password', 'password_confirmation'),
            onSuccess: () => {
                emits('closeModal');
                form.reset();
            },
        })
    }
    const permissionIsAssigned = (permissionName) => {
        return props.roles
            .filter(role => form.selectedRoles.includes(role.name))
            .some(role => role.permissions.some(permission => permission.name === permissionName));
    }

    onBeforeMount(async () => {
        if (props.user) {
            form.first_name = props.user.first_name;
            form.last_name = props.user.last_name;
            form.email = props.user.email;
            form.selectedRoles = props.user.roles.map(role => role.name);

            action = 'edit';
        }
    })

    const closeModal = () => {
        emits('closeModal');
    }

</script>

<template>
    <div>
        <form @submit.prevent="handleSubmit" class="flex flex-col gap-y-6">
<!--        CSRF protection included bij Inertia useForm()-->

            <h2 class="text-lg font-medium uppercase w-full bg-background rounded-lg px-3 py-1.5 ">Personal information</h2>
            <div class="flex flex-col gap-y-1">
                <div class="px-3 grid grid-cols-3 py-3">
                    <div class="col-span-1 flex flex-col items-center">
                        <CustomTooltip v-if="action === 'edit'" content="Leave blank to keep current image." placement="bottom">
                            <template #trigger>
                                <DropzoneSingleImage v-model="form.avatar" rounded="full" />
                            </template>
                        </CustomTooltip>
                        <DropzoneSingleImage v-else v-model="form.avatar" rounded="full" />

                        <p v-if="form.errors.avatar" class="text-danger text-sm">{{ form.errors.avatar }}</p>
                    </div>

                    <div class="col-span-2 pl-6">
                        <TextInput v-model="form.first_name" name="First Name" type="text" autocomplete="given-name" required :message="form.errors.first_name" />
                        <TextInput v-model="form.last_name" name="Last Name" type="text" autocomplete="family-name" required :message="form.errors.last_name" />
                    </div>
                </div>

                <div class="flex flex-col gap-y-4 px-3">
                    <TextInput v-model="form.email" name="Email" type="email" autocomplete="email" required :message="form.errors.email" />
                    <CustomTooltip v-if="action === 'edit'" content="Leave blank to keep to keep current password" placement="bottom">
                        <template #trigger>
                            <div class="grid grid-cols-2 gap-3">
                                <TextInput v-model="form.password" name="Password" type="password" autocomplete="new-password" :message="form.errors.password" />
                                <TextInput v-model="form.password_confirmation" name="Confirm password" type="password" autocomplete="new-password" />
                            </div>
                        </template>
                    </CustomTooltip>
                    <div v-else class="grid grid-cols-2 gap-3">
                        <TextInput v-model="form.password" name="Password" type="password" autocomplete="new-password" required :message="form.errors.password" />
                        <TextInput v-model="form.password_confirmation" name="Confirm password" type="password" autocomplete="new-password" required />
                    </div>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center w-full bg-background rounded-lg px-3 py-1.5 mb-6">
                    <h2 class="text-lg font-medium uppercase">Roles and Permissions</h2>
                    <CustomTooltip content="Permissions can only be assigned based on roles." placement="bottom">
                        <template #trigger>
                            <Icon icon="informationCircle" :size="5" class="text-text-muted" ref="infoIcon" />
                        </template>
                    </CustomTooltip>
                </div>
                <div class="px-3 flex flex-col gap-y-2">
                    <div class="flex gap-x-3">
                        <div class="w-1/4 flex flex-col gap-y-2 pl-3 pt-2">
                            <div v-for="(role) in props.roles" :key="role.id" class="flex gap-x-3">
                                <input v-model="form.selectedRoles" :value="role.name" type="checkbox" :id="role.name+'.checkbox'" class="border-secondary focus:outline-accent accent-accent">
                                <label :for="role.name+'.checkbox'"> {{ role.name }} </label>
                            </div>
                        </div>

                        <div class="w-3/4 flex flex-col gap-y-3">
                            <div v-for="category in permissionCategories" :key="category.id" class="flex flex-col gap-y-3 border border-secondary rounded-lg p-2">
                                <button @click="showCategory = showCategory === category.id ? null : category.id" type="button" class="font-medium flex justify-between items-center">
                                    <p class="text-base font-normal">{{ category.name }}</p>
                                    <Icon icon="chevronDown" :size="4" :class="showCategory === category.id ? 'rotate-180' : ''" />
                                </button>
                                <div v-if="showCategory === category.id" class="grid grid-cols-3 mt-1">
                                    <div v-for="permission in category.permissions" :key="permission.id" class="flex gap-x-2">
                                        <input type="checkbox" :id="permission.name+'.checkbox'" disabled :checked="permissionIsAssigned(permission.name)" class="border-secondary focus:outline-accent accent-accent">
                                        <label :for="permission.name+'.checkbox'"> {{ ucFirst(permission.name.replace('.', ' '))+'s' }} </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p v-if="form.errors.selectedRoles" class="text-danger text-sm pl-3">{{ form.errors.selectedRoles }}</p>
                </div>
            </div>
            <div class="flex gap-x-3 justify-end items-end mt-6">
                <Button @click="closeModal" type="button" size="md" color="background"> Cancel </Button>
                <Button type="submit" size="md" color="success" :disabled="form.processing"> {{ ucFirst(action) }} </Button>
            </div>
        </form>
    </div>
</template>
