<script setup>
    const props = defineProps({
        users: {
            type: Object,
            required: true,
        }
    })
</script>

<template>
    <table class="relative w-full">
        <thead class="sticky top-0 bg-surface shadow-bottom text-left">
        <tr>
            <th class="pl-6 pt-6 pb-4">avatar</th>
            <th class="pt-6 pb-4">Email</th>
            <th class="pt-6 pb-4">First name</th>
            <th class="pt-6 pb-4">Last name</th>
            <th class="pt-6 pb-4">Verified</th>
            <th class="pt-6 pb-4">Last login</th>
            <th class="pr-6 pt-6 pb-4">Created at</th>
        </tr>
        </thead>

        <tbody>
        <tr v-for="(user, index) in props.users.data"
            :key="index"
            :class="['px-6', (index + 1) % 2 === 1 ? 'bg-surface' : 'bg-background']"
        >
            <td class="pl-6 py-3">
                <div>
                    <img v-if="user.avatar" :src="`/assets/${user.avatar.path}`" :alt="user.avatar.alt" class="size-10 rounded-full">
                    <img v-else :src="'/assets/img/placeholders/avatarPlaceholder.png'" alt="avatar placeholder" class="size-10 rounded-full">
                </div>
            </td>
            <td class="py-3">{{ user.email }}</td>
            <td class="py-3">{{ user.first_name }}</td>
            <td class="py-3">{{ user.last_name }}</td>
            <td class="py-3"></td>
            <td class="py-3"></td>
            <td class="py-3"></td>
        </tr>

<!--        <td className={"pl-6 py-3"}>{user.id}</td>-->
<!--            <td className={"py-3"}>-->
<!--                <div className={"size-5"}>-->
<!--                    {user.email_verified_at-->
<!--                    ? <Icon name={"check"} className={"text-success"}/>-->
<!--                    : <Icon name={"x"} className={"text-danger"}/>-->
<!--                    }-->
<!--                </div>-->
<!--            </td>-->
<!--            <td className={"py-3"}>{user.last_login-->
<!--                ? user.last_login.toLocaleDateString('nl-BE')-->
<!--                : '-'-->
<!--                }-->
<!--            </td>-->
<!--            <td className={"pr-6 py-3"}>{user.created_at-->
<!--            ? user.created_at.toLocaleDateString('nl-BE')-->
<!--            : '-'-->
<!--            }-->
<!--            </td>-->
<!--        </tr>-->
        </tbody>
    </table>
</template>
