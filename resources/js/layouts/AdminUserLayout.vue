<script setup>
    import { usePage } from '@inertiajs/vue3'
    import KPICard from '@/components/backend/KPICard.vue'
    import AdminLayout from '@/layouts/AdminLayout.vue'

    const page = usePage();
    const KPI = page.props?.KPI || null;

</script>

<template>
    <AdminLayout>
        <div class="relative flex flex-col gap-y-6 h-full max-h-screen">
            <div v-if="KPI" class="grid grid-cols-3 3xl:grid-cols-4 gap-x-6">
                <KPICard title="All users" :value="KPI.userCount" color="primary" icon="userGroup" :iconBoxSize="16" :iconSize="9" />
                <KPICard title="New users" :value="KPI.newUserCount" color="success" icon="userPlus" :iconBoxSize="16" :iconSize="9" />
                <KPICard title="Active users" :value="KPI.activeUserCount" color="warning" icon="user" :iconBoxSize="16" :iconSize="9" />
                <KPICard title="Retention rate" :value="KPI.retentionRate" unit="%" color="accent" icon="arrowPath" :iconBoxSize="16" :iconSize="9" class="hidden 3xl:flex" />
            </div>

            <slot />
        </div>
    </AdminLayout>
</template>
