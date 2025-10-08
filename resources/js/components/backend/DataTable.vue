<script setup>
    import {timeAgo} from "@/utils/dateHelper.js";
    import Paginator from "@/components/other/Paginator.vue";
    import {router, usePage} from "@inertiajs/vue3";
    import {ref, watch} from "vue";
    import {debounce} from "lodash";
    import TextInput from "@/components/ui/TextInput.vue";
    import Icon from "@/components/other/Icon.vue";
    import Button from "@/components/ui/Button.vue";
    import Avatar from "@/components/backend/Avatar.vue";
    import CustomTooltip from "@/components/other/CustomTooltip.vue";
    import {ucFirst} from "../../utils/textHelper.js";

    const props = defineProps({
        paginator: {
            type: Object,
            required: true,
        },
        filters: {
            type: Object,
        },
        modelName: {
            type: String,
            required: true,
        },
        columns: {
            type: Array,
            required: true,
        }
    })

    const emits = defineEmits([
        'openNew',
        'openEdit',
    ])

    const page = usePage();
    const permissions = page.props.auth.permissions;

    const filters = ref({
        search: props.filters.search || '',
        showDeleted: props.filters.showDeleted || false,
    })
    const allSelected = ref(false);
    const selectedModels= ref([]);

    const routes = {
        index: props.modelName.toLowerCase() + 's.index',
        create: props.modelName.toLowerCase() + 's.create',
        delete: props.modelName.toLowerCase() + 's.delete',
        restore: props.modelName.toLowerCase() + 's.restore',
        bulkDelete: props.modelName.toLowerCase() + 's.bulkDelete',
        bulkRestore: props.modelName.toLowerCase() + 's.bulkRestore',
    };
    const modelPermissions = {
        update: 'update.' + props.modelName.toLowerCase(),
        delete: 'delete.' + props.modelName.toLowerCase(),
        restore: 'restore.' + props.modelName.toLowerCase(),
    }

    watch(filters,
        debounce((value) => {
            router.get(route(routes['index']),
                {
                    search: value.search,
                    showDeleted: value.showDeleted,
                },
                { preserveState: true })
        },300),
        { deep: true }
    );
    watch(allSelected, (value) => {
        if (!props.paginator?.data) return;
        selectedModels.value = value ? props.paginator.data.map(model => model.id) : [];
    });
    watch(selectedModels, (value) => {
        if (!props.paginator?.data) return;
        allSelected.value = props.paginator.data.length && value.length === props.paginator.data.length;
    })

    const clearSelection = () => {
        selectedModels.value = [];
    }
    const deleteModel = (id) => {
        router.delete(route(routes['delete'], id))
    }
    const restoreModel = (id) => {
        router.post(route(routes['restore'], id));
    }
    const bulkDeleteModels = () => {
        router.post(route(routes['bulkDelete']), { ids: selectedModels.value }, {
            onSuccess: () => {
                selectedModels.value = [];
            }
        })
    }
    const bulkRestoreModels = () => {
        router.post(route(routes['bulkRestore']), { ids: selectedModels.value }, {
            onSuccess: () => {
                selectedModels.value = [];
            }
        })
    }
    const openNew = () => {
        emits('openNew');
    }
    const openEdit = (modelId) => {
        emits('openEdit', modelId);
    }
</script>

<template>
    <div class="flex justify-between items-center">
        <Paginator :paginator="props.paginator" textLocation="right" />
        <div class="flex gap-x-6 items-center">
            <div class="flex gap-x-2 items-center">
                <input v-model="filters.showDeleted" type="checkbox" class="border-secondary focus:outline-accent accent-accent">
                <label for="showDeleted">Show deleted {{ props.modelName.toLowerCase() + 's' }}</label>
            </div>
            <TextInput name="search" type="search" v-model="filters.search" :showLabel="false" :placeholder="`search ${props.modelName.toLowerCase() + 's'}...`" class="w-72" />
            <Button @click="openNew" type="button" color="success" size="sm">
                <div class="text-base flex gap-x-4">
                    <Icon icon="plus" :size="5" :strokeWidth="2"></Icon>
                    Add {{ props.modelName }}
                </div>
            </Button>
        </div>
    </div>

    <div class="bg-surface rounded overflow-y-auto px-3">
        <table class="relative w-full mb-3">
            <thead class="sticky top-0 bg-surface shadow-bottom text-left pt-3">
            <tr>
                <th class="pt-6 pb-4 pl-3">
                    <input v-model="allSelected" type="checkbox" class="border-secondary focus:outline-accent accent-accent">
                </th>
                <th v-for="(column, index)  in props.columns" :key="index" class="pt-6 pb-4" :class="column['headClass']">{{ column['title'] ? ucFirst(column['title']) : ucFirst(column['name']) }}</th>
                <th class="pt-6 pb-4">Actions</th>
            </tr>
            </thead>

            <tbody>
            <tr
                v-if="$props.paginator?.data.length"
                v-for="(model, index) in $props.paginator.data"
                :key="model.id"
                :class="model.deleted_at
                            ? 'bg-danger-light'
                            : ((index + 1) % 2 === 1 ? 'bg-surface' : 'bg-background')
                "
            >
                <td class="py-3 pl-3">
                    <input v-model="selectedModels" :value="model.id" type="checkbox" class="border-secondary focus:outline-accent accent-accent">
                </td>
                <td v-for="(column, index) in columns" :key="index" class="py-3" :class="column['dataClass']">
                    <p v-if="column['type'] === 'text'"> {{ model[column['name']] ?? '-' }} </p>

                    <p v-if="column['type'] === 'number'"> {{ model[column['name']] ? new Intl.NumberFormat('nl-BE').format(model[column['name']]) : '-' }} </p>

                    <p v-if="column['type'] === 'date'"> {{ model[column['name']] ? new Date(model[column['name']]).toLocaleDateString('nl-BE') : '-' }} </p>

                    <p v-if="column['type'] === 'timeAgo'"> {{ model[column['name']] ? timeAgo(model[column['name']]) : '-' }} </p>

                    <div v-if="column['type'] === 'boolean'">
                        <Icon v-if="model[column['name']]" icon="check" :size="5" class="text-success" />
                        <Icon v-else icon="x" :size="5" class="text-danger" />
                    </div>

                    <div v-if="column['type'] === 'avatar'">
                        <Avatar :path="model[column['name']]?.path" :alt="model[column['name']]?.alt" :size="6" :userFirstName="model['first_name']" fallBackTextSize="text-sm" />
                    </div>

                </td>
                <td>
                    <div class="flex gap-x-1 items-center">
                        <CustomTooltip v-if="permissions.includes(modelPermissions['update'])" :content="`Edit ${props.modelName}`" placement="bottom">
                            <template #trigger>
                                <button @click="openEdit(model.id)" class="size-6">
                                    <Icon icon="pencilSquare" :size="4" />
                                </button>
                            </template>
                        </CustomTooltip>

                        <CustomTooltip v-if="permissions.includes(modelPermissions['delete'])" :content="`Delete ${props.modelName}`" placement="bottom">
                            <template #trigger>
                                <button
                                    v-if="!model.deleted_at"
                                    @click="deleteModel(model.id)"
                                    class="size-6"
                                >
                                    <Icon icon="trash" :size="4" />
                                </button>
                            </template>
                        </CustomTooltip>

                        <CustomTooltip v-if="permissions.includes(modelPermissions['restore'])" :content="`Restore ${props.modelName}`" placement="bottom">
                            <template #trigger>
                                <button
                                    v-if="model.deleted_at"
                                    @click="restoreModel(model.id)"
                                    class="size-6"
                                >
                                    <Icon icon="arrowPath" :size="4" />
                                </button>
                            </template>
                        </CustomTooltip>

                    </div>
                </td>
            </tr>

            <tr v-else>
                <td :colspan="props.columns.length + 2" class="text-center bg-surface py-3"> {{ `No ${props.modelName}s found.` }} </td>
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
            <div v-if="selectedModels.length" class="fixed bottom-4 left-1/2 transform -translate-x-1/2 z-50 bg-surface py-3 px-6 rounded-lg flex items-center gap-x-6 shadow-lg">
                <p><span class="font-medium">{{ selectedModels.length }}</span> {{ selectedModels.length === 1 ? `${props.modelName}` : `${props.modelName}s` }} selected.</p>
                <Button v-if="permissions.includes(modelPermissions['delete'])" @click="bulkDeleteModels" type="button" color="danger" size="sm" class="flex gap-x-2 items-center">
                    <Icon icon="trash" :size="5" />
                    Delete {{ selectedModels.length === 1 ? `${props.modelName}` : `${props.modelName}s` }}
                </Button>
                <Button v-if="filters.showDeleted && permissions.includes(modelPermissions['restore'])" @click="bulkRestoreModels" type="button" color="success" size="sm" class="flex gap-x-2 items-center">
                    <Icon icon="arrowPath" :size="5" />
                    Restore {{ selectedModels.length === 1 ? `${props.modelName}` : `${props.modelName}s` }}
                </Button>
                <Button @click="clearSelection" type="button" color="background" size="sm" class="flex gap-x-2 items-center">
                    <Icon icon="x" :size="5" />
                    Clear selection
                </Button>
            </div>
        </Transition>

    </div>
</template>
