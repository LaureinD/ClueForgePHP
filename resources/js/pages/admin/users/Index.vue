<script setup>
    import {router} from "@inertiajs/vue3";
    import {ref, watch} from "vue";
    import {debounce} from "lodash";
    import {timeAgo} from "../../../utils/dateHelper.js";
    import KPICard from "@/components/backend/KPICard.vue";
    import Icon from "@/components/other/Icon.vue";
    import Avatar from "@/components/backend/Avatar.vue";
    import Paginator from "@/components/other/Paginator.vue";
    import TextInput from "@/components/ui/TextInput.vue";
    import Button from "@/components/ui/Button.vue";

    const props = defineProps({
        filters: {
            type: Object,
        },
        KPI: {
            type: Object
        },
        users: {
            type: Object
        }
    })

    const filters = ref({
        search: props.filters.search || '',
        showDeleted: props.filters.showDeleted || false,
    })
    const allSelected = ref(false);
    const selectedUsers = ref([]);

    watch(filters,
        debounce((value) => {
                router.get(route('users.index'),
                {
                    search: value.search,
                    showDeleted: value.showDeleted,
                },
                { preserveState: true })
        },300),
        { deep: true }
    );
    watch(allSelected, (value) => {
        if (!props.users?.data) return;
        selectedUsers.value = value ? props.users.data.map(user => user.id) : [];
    });
    watch(selectedUsers, (value) => {
        if (!props.users?.data) return;
        allSelected.value = props.users.data.length && value.length === props.users.data.length;
    })

    const clearSelection = () => {
        selectedUsers.value = [];
    }
    const bulkDelete = () => {
        router.post(route('users.bulkDelete'), { users: selectedUsers.value, _method:'DELETE' }, {
            onSuccess: () => {
                selectedUsers.value = [];
            }
        })
    }
    const bulkRestore = () => {
        router.post(route('users.bulkRestore'), { users: selectedUsers.value }, {
            onSuccess: () => {
                selectedUsers.value = [];
            }
        })
    }

</script>

<template>
    <div class="relative flex flex-col gap-y-6 h-full max-h-screen">
        <div class="w-full grid grid-cols-3 3xl:grid-cols-4 gap-x-6">
            <KPICard title="All users" :value="$props.KPI['userCount']" color="primary" icon="userGroup" :iconBoxSize="16" :iconSize="9" tooltip="All users." />
            <KPICard title="New users" :value="$props.KPI['newUserCount']" color="success" icon="userPlus" :iconBoxSize="16" :iconSize="9" tooltip="Users created during the last 30 days." />
            <KPICard title="Active users" :value="$props.KPI['activeUserCount']" color="warning" icon="user" :iconBoxSize="16" :iconSize="9" tooltip="Users who logged in during the last 30 days." />
            <KPICard title="Retention rate" :value="$props.KPI['retentionRate']" unit="%" color="accent" icon="arrowPath" :iconBoxSize="16" :iconSize="9" tooltip="Percentage of new users who are still active 14 days after creating their account." class="hidden 3xl:flex" />
        </div>

        <div class="flex justify-between items-center">
            <Paginator :paginator="props.users" textLocation="right" />
            <div class="flex gap-x-6 items-center">
                <div class="flex gap-x-2 items-center">
                    <input v-model="filters.showDeleted" type="checkbox" class="border-secondary focus:outline-accent accent-accent">
                    <label for="showDeleted">Show deleted users</label>
                </div>
                <TextInput name="search" type="search" v-model="filters.search" :showLabel="false" placeholder="Search user..." class="w-72" />
            </div>
        </div>

        <div class="bg-surface rounded overflow-y-scroll px-3">
            <table class="relative w-full mb-3">
                <thead class="sticky top-0 bg-surface shadow-bottom text-left pt-3">
                <tr>
                    <th class="pt-6 pb-4 pl-3">
                        <input v-model="allSelected" type="checkbox" class="border-secondary focus:outline-accent accent-accent">
                    </th>
                    <th class="pt-6 pb-4 w-[120px]">Avatar</th>
                    <th class="pt-6 pb-4">Email</th>
                    <th class="pt-6 pb-4">First name</th>
                    <th class="pt-6 pb-4">Last name</th>
                    <th class="pt-6 pb-4 text-center">Verified</th>
                    <th class="pt-6 pb-4 text-center">Last login</th>
                    <th class="pt-6 pb-4 pr-6 text-center">Created at</th>
                </tr>
                </thead>

                <tbody>
                <tr
                    v-if="$props.users?.data.length"
                    v-for="(user, index) in $props.users.data"
                    :key="user.id"
                    :class="user.deleted_at
                            ? 'bg-danger-light'
                            : ((index + 1) % 2 === 1 ? 'bg-surface' : 'bg-background')
                    "
                >
                    <td class="py-3 pl-3">
                        <input v-model="selectedUsers" :value="user.id" type="checkbox" class="border-secondary focus:outline-accent accent-accent">
                    </td>
                    <td class="py-3 flex items-center w-[120px]">
                        <Avatar :path="user.avatar?.path" :alt="user.avatar?.alt" :size="6" :userFirstName="user.first_name" fallBackTextSize="text-sm" />
                    </td>
                    <td class="py-3">{{ user.email }}</td>
                    <td class="py-3">{{ user.first_name }}</td>
                    <td class="py-3">{{ user.last_name }}</td>
                    <td class="py-3 flex justify-center align-center">
                        <Icon v-if="user.email_verified_at" icon="check" :size="5" class="text-success" />
                        <Icon v-else icon="x" :size="5" class="text-danger" />
                    </td>
                    <td class="py-3 text-center">
                        {{user.last_login
                            ? timeAgo(user.last_login) ?? '-'
                            : '-'
                        }}
                    </td>
                    <td class="py-3 pr-6 text-center">{{user.created_at ? new Date(user.created_at).toLocaleDateString('nl-BE') : '-'}}</td>
                </tr>

                <tr v-else>
                    <td colspan="7" class="text-center bg-surface py-3">No users found.</td>
                </tr>
                </tbody>
            </table>

            <Transition
                enter-active-class="transition-transform duration-300"
                enter-from-class="translate-y-20 opacity-0"
                enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition-transform duration-200"
                leave-from-class="translate-y-0 opacity-100"
                leave-to-class="translate-y-20 opacity-0"
            >
                <div v-if="selectedUsers.length" class="fixed bottom-4 left-1/2 transform -translate-x-1/2 z-50 bg-surface py-3 px-6 rounded-lg flex items-center gap-x-6 shadow-lg">
                    <p><span class="font-medium">{{ selectedUsers.length }}</span> {{ selectedUsers.length === 1 ? 'user' : 'users' }} selected.</p>
                    <Button @click="bulkDelete" type="button" color="danger" size="sm" class="flex gap-x-2 items-center">
                        <Icon icon="trash" :size="5" />
                        Delete {{ selectedUsers.length === 1 ? 'user' : 'users' }}
                    </Button>
                    <Button v-if="filters.showDeleted" @click="bulkRestore" type="button" color="success" size="sm" class="flex gap-x-2 items-center">
                        <Icon icon="arrowPath" :size="5" />
                        Restore {{ selectedUsers.length === 1 ? 'user' : 'users' }}
                    </Button>
                    <Button @click="clearSelection" type="button" color="background" size="sm" class="flex gap-x-2 items-center">
                        <Icon icon="x" :size="5" />
                        Clear selection
                    </Button>
                </div>
            </Transition>

        </div>
    </div>
</template>
