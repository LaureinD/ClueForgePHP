<template>
    <img v-if="$page.props.auth.avatar" :src="`assets/${$page.props.auth.avatar.path}`" :alt="$page.props.auth.avatar.alt" class="size-10 rounded-full">
    <div v-else class="size-10 rounded-full flex items-center justify-center bg-accent text-surface">
        <p class="uppercase text-xl font-semibold size-2 flex items-center justify-center"> {{ $page.props.auth.user ? $page.props.auth.user.first_name[0] :'?' }} </p>
    </div>
</template>
