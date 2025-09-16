<script setup>
    import { Link } from '@inertiajs/vue3';
    import {ref} from "vue";

    const faqs = [
        {
            title: "Getting Started",
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                       stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"/>
                </svg>`,
            items: [
                {
                    question: "What is ClueForge?",
                    answer:
                        "A powerful online tool that lets you design, organize, and share custom escape rooms — no coding skills needed.",
                },
                {
                    question: "Do I need any experience to use ClueForge?",
                    answer:
                        "Not at all! ClueForge is built for beginners and pros alike. Our interface is intuitive and user-friendly.",
                },
                {
                    question: "Is there a free version available?",
                    answer: "Yes, you can start with our free Starter plan and upgrade whenever you need more features.",
                },
                {
                    question: "Can I test ClueForge without creating an account?",
                    answer:
                        "Currently, you need an account to save and manage your puzzles, but signing up is quick and free.",
                },
                {
                    question: "What kind of escape rooms can I create?",
                    answer:
                        "From classroom games to corporate team-building or complex puzzle adventures — ClueForge is flexible enough for all types.",
                },
            ],
        },
        {
            title: "Features & Usage",
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                </svg>`,
            items: [
                {
                    question: "Can I reuse or duplicate puzzles?",
                    answer:
                        "Yes! You can easily copy puzzles from your library and adapt them for new escape rooms.",
                },
                {
                    question: "Can I work on a project with others?",
                    answer:
                        "No, at the moment collaboration is not available. You can, however, share your creations with friends.",
                },
                {
                    question: "Can I upload images, documents, or media to puzzles?",
                    answer:
                        "Absolutely — every puzzle and room supports attachments for clues, visuals, or instructions.",
                },
                {
                    question: "Is there a library of pre-made puzzles?",
                    answer:
                        "Yes! You can explore and use puzzles from our shared online library to get inspired or save time.",
                },
                {
                    question: "How do I organize my escape rooms?",
                    answer:
                        "Use folders, tags, and overviews to group puzzles and plan each room clearly and efficiently.",
                },
            ],
        },
        {
            title: "Plans & Account",
            icon: `<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>`,
            items: [
                {
                    question: "What happens if I cancel my subscription?",
                    answer:
                        "Your content stays safe. You’ll switch to the free plan and lose access to premium features, but your work remains available.",
                },
                {
                    question: "Can I upgrade or downgrade my plan at any time?",
                    answer:
                        "Yes, you can switch plans at any time — changes will take effect at the end of your current billing period, so you’ll continue to enjoy your current features until then.",
                },
                {
                    question: "Is my data and content secure?",
                    answer:
                        "Yes, we take data privacy seriously. All your content is stored securely and backed up regularly.",
                },
                {
                    question: "Do you offer discounts for educators or non-profits?",
                    answer:
                        "Yes! Reach out to us and we’ll be happy to discuss custom pricing options.",
                },
                {
                    question: "What payment methods do you accept?",
                    answer:
                        "We support major credit cards and soon also PayPal and other local options.",
                },
            ],
        },
    ];

    let openFaqIndex = ref(null);
</script>

<template>
    <Head>
        <title>Help</title>
    </Head>

    <div class="p-6 flex flex-col gap-20">
        <div class="w-1/2 mx-auto mt-24 flex justify-center items-center flex-col gap-6 text-center">
            <h1 class="text-6xl leading-20">Need help with Clue<span class="text-accent">Forge</span>?</h1>
            <h2 class="text-xl leading-8">Find your answers below or <Link :href="route('contact')" class="text-accent">contact us</Link>  with your question!</h2>
        </div>

        <div class="w-2/3 mx-auto px-4 py-8">
            <div v-for="(section, sectionIndex) in faqs" :key="sectionIndex" class="mb-20">
                <div class="flex items-center gap-2 mb-4">
                    <div v-html="section.icon"></div>
                    <h2 class="text-xl font-bold">{{ section.title }}</h2>
                </div>

                <div class="space-y-4">
                    <div
                        v-for="(faq, faqIndex) in section.items"
                        :key="`${sectionIndex}-${faqIndex}`"
                        class="border rounded-md overflow-hidden"
                    >
                        <button
                            @click="
                                openFaqIndex = openFaqIndex === `${sectionIndex}-${faqIndex}`
                                    ? null
                                    : `${sectionIndex}-${faqIndex}`
                            "
                            class="w-full text-left px-4 py-3 flex justify-between items-center hover:bg-gray-50 font-medium"
                        >
                            {{ faq.question }}

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5" :class="openFaqIndex === `${sectionIndex}-${faqIndex}` ? 'rotate-180' : '' ">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        <div
                            v-if="openFaqIndex === `${sectionIndex}-${faqIndex}`"
                            class="px-4 pb-4 my-3 text-gray-700"
                        >
                            {{ faq.answer }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
