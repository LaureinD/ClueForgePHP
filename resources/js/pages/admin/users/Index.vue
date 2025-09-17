<script setup>
    import KPICard from "@/components/backend/KPICard.vue";

    const props = defineProps({
        users: {
            type: Object
        }
    })
</script>

<template>
    <div class="relative flex flex-col gap-y-6 h-full">
        <div class="w-full grid grid-cols-3 3xl:grid-cols-4 gap-x-6">
            <KPICard title="All users" :value="5" color="primary" icon="userGroup" :iconBoxSize="16" :iconSize="10" tooltip="All users." />
            <KPICard title="New users" :value="5" color="success" icon="userPlus" :iconBoxSize="16" :iconSize="10" tooltip="Users created during the last 30 days." />
            <KPICard title="Active users" :value="5" color="warning" icon="user" :iconBoxSize="16" :iconSize="10" tooltip="Users who logged in during the last 30 days." />
            <KPICard title="Retention rate" :value="5" color="accent" icon="arrowPath" :iconBoxSize="16" :iconSize="10" tooltip="Percentage of new users who are still active 14 days after creating their account." class="hidden 3xl:flex" />
        </div>
    </div>
</template>
