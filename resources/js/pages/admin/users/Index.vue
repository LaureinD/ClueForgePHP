<script setup>
    import DataTable from "@/components/backend/DataTable.vue";
    import {ref} from "vue";
    import ShowUser from "@/pages/admin/users/ShowUser.vue";
    import CreateOrEditForm from "@/pages/admin/users/CreateOrEditForm.vue";
    import Modal from "@/components/other/Modal.vue";

    const props = defineProps({
        filters: {
            type: Object,
        },
        users: {
            type: Object
        },
        roles: {
            type: Array,
        },
        permissionCategories: {
            type: Array,
        }
    })

    const columns = [
        {
            name: 'avatar',
            type: 'avatar',
            headClass: 'w-[120px]',
            dataClass: 'flex items-center w-[120px]',
        },
        {
            name: 'email',
            type: 'text',
        },
        {
            name: 'first_name',
            title: 'first name',
            type: 'text',
        },
        {
            name: 'last_name',
            title: 'last name',
            type: 'text',
        },
        {
            name: 'email_verified_at',
            title: 'verified',
            type: 'boolean',
            headClass: 'text-center'
        },
        {
            name: 'last_login',
            title: 'last login',
            type: 'timeAgo',
            headClass: 'text-center',
            dataClass: 'text-center'
        },
        {
            name: 'created_at',
            title: 'created at',
            type: 'date',
        },
    ];

    const showModal = ref('');
    const selectedUser = ref(null);

    const setEditUser = (userId) => {
        selectedUser.value = props.users.data.find(user => user.id === userId);
        showModal.value = 'Edit user'
    }
    const closeModal = () => {
        showModal.value = '';
        selectedUser.value = null;
    }

</script>

<template>
    <DataTable
        @openNew="showModal = 'Create user'"
        @openEdit="setEditUser"
        :columns="columns"
        model-name="user"
        :paginator="props.users"
        :filters="props.filters"
    />

    <Modal
        v-if="showModal.length"
        @closeModal="closeModal"
        :title="showModal"
    >
        <CreateOrEditForm
            @closeModal="closeModal"
            v-if="showModal === 'Create user' || showModal === 'Edit user'"
            :permission-categories="props.permissionCategories"
            :roles="props.roles"
            :user="selectedUser"
        />

        <ShowUser @closeModal="closeModal" v-if="showModal === 'Show'" />
    </Modal>
</template>
