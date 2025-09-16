<script setup>
    import Button from "@/components/ui/Button.vue";
    import {ref} from "vue";

    // todo: read plans from database
    const plans = [
        {
            name: 'Pro',
            price: {
                monthly: 3.99,
                yearly: 42.99,
            },
            description: 'More power and flexibility for frequent creators and small teams.',
            features: [
                'Create up to 100 riddles',
                'Create up to 10 escape rooms',
                'Mark riddles and escape rooms as private',
                'Access to the public library',
                '2 GB uploads'
            ]
        },
        {
            name: 'Advanced',
            price: {
                monthly: 5.99,
                yearly: 69.99,
            },
            description: 'Advanced features and collaboration tools for serious designers.',
            features: [
                'Create unlimited riddles',
                'Create unlimited escape rooms',
                'Mark riddles and escape rooms as private',
                'Access to the public library',
                '50 GB uploads'
            ]
        },
        {
            name: 'Enterprise',
            price: {
                monthly: 9.99,
                yearly: 109.99,
            },
            description: 'Scalable solutions with full support for large teams and organizations.',
            features: [
                'Create unlimited riddles',
                'Create unlimited escape rooms',
                'Mark riddles and escape rooms as private',
                'Access to the public library',
                '100 GB uploads + 2GB per user',
                'Customizable plan limits based on your organization\'s needs'
            ]
        },
        {
            name: 'Starter',
            price: {
                monthly: 0,
                yearly: 0,
            },
            description: 'All the essentials to start creating escape rooms with ease.',
            features: [
                'Create up to 20 riddles',
                'Create up to 1 escape room',
                'Access to the public library',
                '250 MB uploads',
            ]
        },
    ]

    const paymentMethod = ref('monthly');
    function setPaymentMethod(method) {
        paymentMethod.value = method;
        console.log(paymentMethod)
    }
</script>

<template>
    <Head>
        <title>Pricing</title>
    </Head>

    <div class="p-6 flex flex-col gap-12">
        <div class="w-1/2 mx-auto mt-24 flex justify-center items-center flex-col gap-6 text-center">
            <h1 class="text-6xl leading-20">Which Clue <span class="text-accent">Forge</span> plan is right for me?</h1>
        </div>

        <div class="w-full flex flex-col items-center gap-12">
            <div class="rounded-full border border-secondary flex items-center w-48 overflow-hidden font-semibold">
                <button
                    :class="`w-1/2 py-3 text-center ${paymentMethod === 'monthly' ? 'bg-accent text-white' : ''}`"
                    @click="setPaymentMethod('monthly')"
                >
                    Monthly
                </button>
                <button
                    :class="`w-1/2 py-3 text-center ${paymentMethod === 'yearly' ? 'bg-accent text-white' : ''}`"
                    @click="setPaymentMethod('yearly')"
                >
                    Yearly
                </button>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <div
                v-for="(plan, index) in plans"
                :key="index"
                :class="`p-6 border border-secondary-light rounded-lg shadow shadow-background ${plan.name === 'Starter' ? 'col-span-3 h-68 flex justify-between gap-32' : ''}`"
            >
                <div :class="plan.name === 'Starter' ? '' : 'border-b border-background'">
                    <h3 class="font-bold uppercase text-xl">{{ plan.name }}</h3>
                    <div v-if="plan.name === 'Starter'">
                        <p class="text-3xl my-8">Free</p>
                    </div>
                    <div v-else class="flex flex-col gap-2 my-8">
                        <p class="text-3xl">€ {{ paymentMethod === 'monthly' ? plan.price.monthly : plan.price.yearly }} <span class="text-base">/{{ paymentMethod === 'monthly' ? 'month' : 'year' }}</span></p>
                        <p class="text-secondary">Pay € {{ paymentMethod === 'monthly' ? plan.price.yearly : plan.price.monthly }} {{ paymentMethod === 'monthly' ? 'yearly' : 'monthly' }}</p>
                    </div>

                    <p v-if="plan.name === 'Starter'" class="my-3">{{ plan. description }}</p>
                </div>

                <p v-if="plan.name !== 'Starter'" class="my-3">{{ plan. description }}</p>

                <div v-if="plan.name !== 'Starter'" class="w-full flex justify-center">
                    <Button size="md" color="success" class="my-8">
                        Choose {{  plan.name }}
                    </Button>
                </div>

                <div :class="`my-3 text-sm ${plan.name === 'Starter' ? 'flex-grow' : ''}`">
                    <h4 class="text-lg mb-6">What's included:</h4>

                    <div
                        v-for="(item, index) in plan.features"
                        :key="plan+'-'+index"
                        class="flex gap-3 my-3"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke-width="1.5" stroke="currentColor" class="size-6 text-success">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                        </svg>
                        <p>{{ item }}</p>
                    </div>
                </div>

                <div v-if="plan.name === 'Starter'" class="flex flex-col justify-end">
                    <Button size="md" color="success">
                        Choose {{  plan.name }}
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>
