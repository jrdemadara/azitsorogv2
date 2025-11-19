<script setup>
import { ref } from "vue";
import { RouterLink } from "vue-router";
import {
    MapPinHouse,
    Phone,
    Smartphone,
    Mail,
    Facebook,
    HandHeart,
    MessageCircle,
    ArrowUpRight,
} from "lucide-vue-next";

const contactGroups = [
    {
        title: "Front desk & officers",
        icon: Phone,
        entries: [
            { label: "+63 919 991 7747", href: "tel:+639199917747" },
            { label: "+63 917 676 3907", href: "tel:+639176763907" },
            { label: "+63 2 8935 1542", href: "tel:+63289351542" },
            { label: "+63 2 8938 7214", href: "tel:+63289387214" },
            { label: "+63 2 8990 2306", href: "tel:+63289902306" },
            { label: "+63 2 8656 5899", href: "tel:+63286565899" },
            { label: "+63 2 8404 4187", href: "tel:+63284044187" },
            { label: "+63 2 8404 4834", href: "tel:+63284044834" },
            { label: "+63 2 8656 8605", href: "tel:+63286568605" },
        ],
    },
    {
        title: "Technical & sales support",
        icon: HandHeart,
        entries: [
            { label: "Luzon: +63 917 516 2251", href: "tel:+639175162251" },
            { label: "Visayas: +63 917 806 0854", href: "tel:+639178060854" },
            { label: "Mindanao: +63 999 839 0945", href: "tel:+639998390945" },
            { label: "Mindanao landline: 082 224 6928", href: "tel:0822246928" },
        ],
    },
];

const message = ref({
    name: "",
    email: "",
    company: "",
    notes: "",
});
</script>

<template>
    <div class="bg-slate-50 py-16">
        <div class="mx-auto flex max-w-6xl flex-col gap-12 px-6 lg:flex-row">
            <div class="flex-1 space-y-8">
                <div class="space-y-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-blue-400">
                        Contact Azitsorog
                    </p>
                    <h1 class="text-3xl font-bold text-slate-900 sm:text-4xl">
                        Talk to a Matica-certified partner
                    </h1>
                    <p class="text-slate-600">
                        Share your issuance, engraving, or access-control plans—we’ll route you to
                        the right regional engineers.
                    </p>
                </div>
                <div class="rounded-3xl border border-white bg-white p-6 shadow-lg">
                    <div class="flex items-start gap-3 text-slate-700">
                        <MapPinHouse class="text-blue-500" :size="24" />
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.4em] text-blue-400">
                                Visit us
                            </p>
                            <a
                                href="https://www.google.com/maps/search/?api=1&query=No.+103+Gloria+St.+Corner+Ortigas+Ext.,+Marick+Subd.,+Cainta,+Rizal+Philippines+1900"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="mt-2 block text-lg font-semibold text-slate-900 hover:text-blue-600"
                            >
                                No. 103 Gloria St. Corner Ortigas Ext., Marick Subd., Cainta, Rizal 1900
                            </a>
                        </div>
                    </div>
                    <div class="mt-6 grid gap-6 lg:grid-cols-2">
                        <div v-for="group in contactGroups" :key="group.title" class="space-y-3">
                            <div class="flex items-center gap-2 text-sm font-semibold text-slate-500">
                                <component :is="group.icon" :size="18" class="text-blue-500" />
                                {{ group.title }}
                            </div>
                            <div class="space-y-2">
                                <a
                                    v-for="entry in group.entries"
                                    :key="entry.label"
                                    :href="entry.href"
                                    class="flex items-center justify-between rounded-2xl border border-slate-100 px-4 py-3 text-sm font-semibold text-slate-800 transition hover:-translate-y-0.5 hover:border-blue-300 hover:bg-blue-50"
                                >
                                    {{ entry.label }}
                                    <Smartphone :size="16" class="text-blue-500" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 grid gap-4 border-t border-slate-100 pt-6 text-sm text-slate-700 lg:grid-cols-2">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-slate-500">
                                <Mail :size="18" class="text-blue-500" />
                                Email
                            </div>
                            <a
                                href="mailto:president@azitsoroginc.com"
                                class="font-semibold text-slate-900 hover:text-blue-600"
                            >
                                president@azitsoroginc.com
                            </a>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-slate-500">
                                <Facebook :size="18" class="text-blue-500" />
                                Facebook
                            </div>
                            <a
                                target="_blank"
                                href="https://www.facebook.com/p/azitsorog-incorporated-100063541945604/"
                                class="font-semibold text-slate-900 hover:text-blue-600"
                            >
                                Azitsorog Inc. Official
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1 rounded-[32px] border border-blue-100 bg-white p-8 shadow-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.4em] text-blue-400">
                    Send us a note
                </p>
                <h2 class="mt-4 text-2xl font-bold text-slate-900">
                    We’ll align the right engineer and timeline.
                </h2>
                <p class="mt-3 text-sm text-slate-500">
                    Drop your details and we’ll respond within one business day.
                </p>
                <form class="mt-8 space-y-4">
                    <div>
                        <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Full name</label>
                        <input
                            v-model="message.name"
                            type="text"
                            class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-400 focus:outline-none"
                            placeholder="Jane Dela Cruz"
                        />
                    </div>
                    <div>
                        <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Work email</label>
                        <input
                            v-model="message.email"
                            type="email"
                            class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-400 focus:outline-none"
                            placeholder="you@company.com"
                        />
                    </div>
                    <div>
                        <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Company / agency</label>
                        <input
                            v-model="message.company"
                            type="text"
                            class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-400 focus:outline-none"
                            placeholder="Organization name"
                        />
                    </div>
                    <div>
                        <label class="text-xs uppercase tracking-[0.3em] text-slate-400">Project notes</label>
                        <textarea
                            v-model="message.notes"
                            rows="4"
                            class="mt-2 w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:border-blue-400 focus:outline-none"
                            placeholder="Tell us about the deployment, timeline, or requirements."
                        ></textarea>
                    </div>
                    <button
                        type="button"
                        class="flex w-full items-center justify-center gap-2 rounded-full bg-blue-500 px-4 py-3 text-sm font-semibold uppercase tracking-wide text-white transition hover:bg-blue-600"
                    >
                        <MessageCircle :size="18" />
                        Submit request
                    </button>
                    <p class="text-xs text-slate-400">
                        By submitting, you agree to be contacted about Matica products distributed by
                        Azitsorog.
                    </p>
                </form>
                <div class="mt-6 rounded-2xl border border-blue-100 bg-blue-50/50 p-4 text-sm text-blue-800">
                    Prefer a call? <RouterLink to="/" class="font-semibold underline">Dial our 24/7 lines</RouterLink>.
                </div>
            </div>
        </div>
    </div>
</template>
