<script setup>
import { RouterLink } from "vue-router";
import {
    Award,
    Calendar,
    CheckCircle2,
    Factory,
    Globe2,
    Lightbulb,
    Shield,
    Target,
    TrendingUp,
    Users,
} from "lucide-vue-next";
import digitalIdentityVisual from "../../images/about-background.jpg";
const milestones = [
    {
        year: "1993",
        title: "Foundation",
        description: "AZITSOROG Trading launched with a mission to design and manufacture trend-setting products.",
    },
    {
        year: "1995",
        title: "World Youth Day",
        description: "Exclusive license from Catholic Bishop Conference to produce and distribute the 10th World Youth Day Unity Band worldwide.",
    },
    {
        year: "1998",
        title: "Centennial Celebration",
        description: "National Centennial Commission exclusive license for Philippine Independence Centennial commemorative products.",
    },
    {
        year: "2000",
        title: "Jubilee Year",
        description: "Licensed to manufacture diverse Jubilee Commemorative Products—wristbands, notebooks, clocks, and signature ID Holder Necklaces.",
    },
    {
        year: "2002",
        title: "Incorporation",
        description: "Officially incorporated as Azitsorog Incorporated, expanding into Digital ID Printing Systems, RFID Access Control, and Security Surveillance.",
    },
];

const values = [
    {
        icon: Target,
        title: "Innovation First",
        description: "Pioneering solutions that set industry standards and drive technological advancement.",
    },
    {
        icon: Shield,
        title: "Trust & Quality",
        description: "Delivering premium-grade products and services that customers can rely on.",
    },
    {
        icon: Users,
        title: "Customer-Centric",
        description: "Sustaining customer trust through exceptional service and competitive pricing.",
    },
    {
        icon: TrendingUp,
        title: "Excellence",
        description: "Commitment to continuous improvement and maintaining the highest standards.",
    },
];

const capabilities = [
    "Digital Identification Card Printing Systems",
    "RFID Access Control Systems",
    "Security Surveillance Systems",
    "Premium ID Accessories Manufacturing",
    "Full Color Logo Pin ID Holder Necklace (Original Creator)",
    "Heavy-Duty Protectors & Retractable ID Holders",
    "Matica Printer & Engraver Distribution",
    "Custom Application Development",
    "Entrance Turnstiles for Schools, Facilities & Government",
];
</script>

<template>
    <div class="flex flex-col bg-white dark:bg-slate-900">
        <main class="flex-grow">
            <!-- Hero Section -->
            <section 
                class="relative w-full overflow-hidden text-white bg-cover bg-no-repeat"
                :style="{ backgroundImage: `url(${digitalIdentityVisual})`}"
            >
                <div class="absolute inset-0 bg-slate-950/80"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 via-slate-900/70 to-transparent"></div>
                <div class="relative mx-auto flex max-w-6xl flex-col items-center gap-8 px-6 py-24 text-center lg:px-20">
                    <div class="rounded-3xl bg-white/10 p-6 backdrop-blur">
                        <img alt="Azitsorog logo" class="mx-auto h-24 w-auto" src="../../images/logo.png" />
                    </div>
                    <div class="space-y-4">
                        <p class="text-sm font-semibold uppercase tracking-[0.4em] text-blue-300">
                            About Azitsorog
                        </p>
                        <h1 class="text-4xl font-black leading-tight sm:text-5xl lg:text-6xl">
                            Pioneering identity solutions
                            <span class="block text-3xl font-semibold text-blue-200 sm:text-4xl">
                                since 1993
                            </span>
                        </h1>
                        <p class="mx-auto max-w-2xl text-lg text-slate-200">
                            Azitsorog Incorporated stands at the forefront of Digital Identification Card Printing
                            Systems, RFID Access Control, Security Surveillance, and premium ID accessories
                            manufacturing in the Philippines.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Company Overview -->
            <section class="bg-white dark:bg-slate-900 px-6 py-16 lg:px-20">
                <div class="mx-auto max-w-6xl">
                    <div class="mb-12 flex flex-col gap-4 text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.4em] text-blue-500 dark:text-blue-400">
                            Our Story
                        </p>
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white sm:text-4xl">
                            Innovation from day one
                        </h2>
                        <p class="mx-auto max-w-3xl text-lg text-slate-600 dark:text-slate-300">
                            As the original creator of the Full Color Logo Pin ID Holder Necklace, Azitsorog has
                            carved its name as a global first-mover in ID accessory innovation. From day one,
                            innovation wasn't just a value—it was the blueprint.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Timeline Section -->
            <section class="bg-slate-50 dark:bg-slate-800/50 px-6 py-16 lg:px-20">
                <div class="mx-auto max-w-6xl">
                    <div class="mb-12 flex flex-col gap-4 text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.4em] text-blue-500 dark:text-blue-400">
                            Our Journey
                        </p>
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white sm:text-4xl">
                            Milestones that shaped us
                        </h2>
                    </div>
                    <div class="space-y-8">
                        <div
                            v-for="(milestone, index) in milestones"
                            :key="milestone.year"
                            class="flex flex-col gap-6 lg:flex-row lg:items-start"
                        >
                            <div class="flex-shrink-0">
                                <div
                                    class="flex h-20 w-20 items-center justify-center rounded-2xl bg-blue-500 dark:bg-blue-600 text-2xl font-bold text-white shadow-lg"
                                >
                                    {{ milestone.year }}
                                </div>
                            </div>
                            <div class="flex-1 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 p-6 shadow-sm">
                                <h3 class="mb-2 text-xl font-semibold text-slate-900 dark:text-white">
                                    {{ milestone.title }}
                                </h3>
                                <p class="text-slate-600 dark:text-slate-300">
                                    {{ milestone.description }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Values Section -->
            <section class="bg-white dark:bg-slate-900 px-6 py-16 lg:px-20">
                <div class="mx-auto max-w-6xl">
                    <div class="mb-12 flex flex-col gap-4 text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.4em] text-blue-500 dark:text-blue-400">
                            Our Philosophy
                        </p>
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white sm:text-4xl">
                            What drives us forward
                        </h2>
                        <p class="mx-auto max-w-3xl text-lg text-slate-600 dark:text-slate-300">
                            Azitsorog Incorporated is driven by a commitment to excellence. Our mission is to
                            distribute state-of-the-art identification and security technologies while delivering
                            premium-grade accessories at fair and competitive prices.
                        </p>
                    </div>
                    <div class="grid gap-6 md:grid-cols-2">
                        <article
                            v-for="value in values"
                            :key="value.title"
                            class="rounded-2xl border border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-800 p-8 shadow-sm transition hover:-translate-y-1 hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-lg"
                        >
                            <component
                                :is="value.icon"
                                class="mb-4 text-blue-500 dark:text-blue-400"
                                :size="32"
                            />
                            <h3 class="mb-3 text-xl font-semibold text-slate-900 dark:text-white">
                                {{ value.title }}
                            </h3>
                            <p class="text-slate-600 dark:text-slate-300">
                                {{ value.description }}
                            </p>
                        </article>
                    </div>
                </div>
            </section>

            <!-- Capabilities Section -->
            <section class="bg-slate-900 px-6 py-16 text-white lg:px-20">
                <div class="mx-auto max-w-6xl">
                    <div class="mb-12 flex flex-col gap-4 text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.4em] text-blue-300">
                            What We Offer
                        </p>
                        <h2 class="text-3xl font-bold sm:text-4xl">
                            Comprehensive identity solutions
                        </h2>
                        <p class="mx-auto max-w-3xl text-lg text-slate-200">
                            From digital printing systems to access control and premium accessories—Azitsorog
                            provides end-to-end solutions for organizations across the Philippines.
                        </p>
                    </div>
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <div
                            v-for="capability in capabilities"
                            :key="capability"
                            class="flex items-start gap-3 rounded-2xl border border-white/10 bg-white/5 p-4 backdrop-blur"
                        >
                            <CheckCircle2 class="mt-0.5 flex-shrink-0 text-blue-300" :size="20" />
                            <span class="text-slate-200">{{ capability }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="bg-blue-600 dark:bg-blue-800 px-6 py-16 text-white lg:px-20">
                <div class="mx-auto flex max-w-6xl flex-col items-center gap-8 text-center">
                    <div class="space-y-4">
                        <h2 class="text-3xl font-bold sm:text-4xl">
                            Ready to transform your identity management?
                        </h2>
                        <p class="mx-auto max-w-2xl text-lg text-blue-100 dark:text-blue-50">
                            As the only authorized Matica distributor in the Philippines, we're here to help you
                            implement secure, scalable solutions tailored to your needs.
                        </p>
                    </div>
                    <div class="flex flex-col gap-4 sm:flex-row">
                        <RouterLink to="/contact" class="w-full sm:w-fit">
                            <button
                                class="flex w-full items-center justify-center gap-2 rounded-full bg-white dark:bg-slate-100 px-8 py-4 font-semibold text-slate-900 transition hover:bg-slate-100 dark:hover:bg-slate-200"
                            >
                                Get in touch
                            </button>
                        </RouterLink>
                        <RouterLink to="/" class="w-full sm:w-fit">
                            <button
                                class="flex w-full items-center justify-center gap-2 rounded-full border border-white/40 px-8 py-4 font-semibold text-white transition hover:border-white hover:bg-white/10"
                            >
                                Explore solutions
                            </button>
                        </RouterLink>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>
