<script setup>
    import KPICard from "@/components/backend/KPICard.vue";
    import Icon from "@/components/other/Icon.vue";
    import {timeAgo} from "../../../utils/dateHelper.js";
    import Avatar from "@/components/backend/Avatar.vue";

    const props = defineProps({
        KPI: {
            type: Object
        },
        users: {
            type: Object
        }
    })
</script>

<template>
    <div class="relative flex flex-col gap-y-6 h-full max-h-screen">
        <div class="w-full grid grid-cols-3 3xl:grid-cols-4 gap-x-6">
            <KPICard title="All users" :value="$props.KPI['userCount']" color="primary" icon="userGroup" :iconBoxSize="16" :iconSize="9" tooltip="All users." />
            <KPICard title="New users" :value="$props.KPI['newUserCount']" color="success" icon="userPlus" :iconBoxSize="16" :iconSize="9" tooltip="Users created during the last 30 days." />
            <KPICard title="Active users" :value="$props.KPI['activeUserCount']" color="warning" icon="user" :iconBoxSize="16" :iconSize="9" tooltip="Users who logged in during the last 30 days." />
            <KPICard title="Retention rate" :value="$props.KPI['retentionRate']" unit="%" color="accent" icon="arrowPath" :iconBoxSize="16" :iconSize="9" tooltip="Percentage of new users who are still active 14 days after creating their account." class="hidden 3xl:flex" />
        </div>

        <div class="bg-surface rounded overflow-y-scroll px-3">
            <table class="relative w-full mb-3">
                <thead class="sticky top-0 bg-surface shadow-bottom text-left pt-3">
                <tr>
                    <th class="pt-6 pb-4 pl-6 w-[120px]">Avatar</th>
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
                    :class="(index + 1) % 2 === 1 ? 'bg-surface' : 'bg-background'"
                >
                    <td class="py-3 pl-6 flex items-center w-[120px]">
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
        </div>
    </div>
</template>
