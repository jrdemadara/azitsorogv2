<script setup>
import { RouterLink } from "vue-router";
import {
    ArrowUpRight,
    Building,
    CheckCircle2,
    CircleArrowRight,
    Globe2,
    Handshake,
    LandPlot,
    Landmark,
    Phone,
    ShieldHalf,
} from "lucide-vue-next";
import productPlaceholder from "../../images/printer2.png";
import digitalIdentityVisual from "../../images/background.jpg";

const heroHighlights = [
    "Secure credential issuance that converges physical and digital identity",
    "Lifecycle management spanning enrollment, issuance, and engagement",
    "Global-grade experience localized for Azitsorog partners",
];

const solutionPillars = [
    {
        title: "Matica Distribution",
        body: "Official channel for Matica printers, engravers, consumables, and lifecycle add-ons—sourced, staged, and delivered by Azitsorog.",
    },
    {
        title: "Implementation & Support",
        body: "Certified deployment, training, and 24/7 support desks that keep issuance, engraving, and personalization pipelines running.",
    },
    {
        title: "Custom Applications",
        body: "Tailored dashboards, enrollment portals, and workflow automations that wrap around Matica hardware to fit local policies.",
    },
    {
        title: "Entrance Turnstiles",
        body: "Design, supply, and maintain secure turnstile systems for schools, government facilities, and private campuses that require credential-aware access.",
    },
];

const stats = [
    { label: "Years securing identities", value: "20+", icon: ShieldHalf },
    { label: "Global offices", value: "10", icon: Globe2 },
    { label: "Partners worldwide", value: "200+", icon: Handshake },
    { label: "Identities secured / year", value: "100M+", icon: LandPlot },
];

const markets = [
    {
        title: "Financial Services",
        copy: "Transform issuance and customer onboarding with frictionless but compliant credentialing.",
    },
    {
        title: "Government",
        copy: "Empower agencies to protect citizens via high-assurance national IDs and permits.",
    },
    {
        title: "Enterprise",
        copy: "Safeguard campuses and ecosystems with converged access across devices and locations.",
    },
];

const convergentSteps = [
    "Centralized personalization pipelines with monitoring and alerts.",
    "Distributed enrollment kits that sync securely with HQ.",
    "Analytics that spotlight anomalies before they become risks.",
];

const products = [
    {
        name: "XID8300",
        type: "Retransfer printer",
        highlights: [
            "300 dpi dual-sided printing",
            "120 full-color cards / hr",
            "Inline single or dual lamination",
        ],
    },
    {
        name: "XID8600",
        type: "Retransfer printer",
        highlights: [
            "600 dpi ultra high resolution",
            "125 cards / hr with security printing",
            "Multiple encoding + lamination options",
        ],
    },
    {
        name: "MC660",
        type: "Direct-to-card printer",
        highlights: [
            "600 dpi precision printing",
            "150 cards / hr throughput",
            "Inline lamination or laser modules",
        ],
    },
    {
        name: "MC110",
        type: "Direct-to-card printer",
        highlights: [
            "300 dpi vibrant output",
            "Up to 150 color cards / hr",
            "Contactless encoding-ready",
        ],
    },
    {
        name: "MC210",
        type: "Direct-to-card printer",
        highlights: [
            "LCD-guided operations",
            "Inline lamination option",
            "300 dpi, 180 color cards / hr",
        ],
    },
    {
        name: "MC310",
        type: "Direct-to-card printer",
        highlights: [
            "300 dpi premium edge-to-edge",
            "180 color cards / hr",
            "Modular lamination / laser upgrades",
        ],
    },
];
</script>

<template>
    <div class="flex flex-col bg-white">
        <main class="flex-grow">
            <section
                class="relative w-full overflow-hidden text-white"
                :style="{ backgroundImage: `url(${digitalIdentityVisual})` }"
            >
                <div class="absolute inset-0 bg-slate-950/80"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-slate-950/80 via-slate-900/70 to-transparent"></div>
                <div
                    class="relative mx-auto flex max-w-6xl flex-col gap-10 px-6 py-24 lg:flex-row lg:items-center lg:gap-16 lg:px-20"
                >
                    <div class="flex w-full flex-col space-y-6">
                        <p class="uppercase tracking-[0.4em] text-sm text-red-400">
                            Azitsorog Internal Suite
                        </p>
                        <h1 class="text-4xl font-black leading-tight sm:text-5xl lg:text-6xl">
                            Digital identity
                            <span class="block text-3xl font-semibold text-slate-200 sm:text-4xl">
                                Converging physical and digital worlds
                            </span>
                        </h1>
                        <p class="text-lg text-slate-200">
                            Inspired by Matica Group’s hero presentation, we lead with a full-bleed
                            story that showcases Azitsorog as the partner for secure issuance,
                            engravers, and the applications that bind them together.
                        </p>
                        <ul class="space-y-3">
                            <li
                                v-for="highlight in heroHighlights"
                                :key="highlight"
                                class="flex items-start text-slate-200"
                            >
                                <CheckCircle2 class="mr-3 mt-0.5 text-red-300" :size="20" />
                                <span>{{ highlight }}</span>
                            </li>
                        </ul>
                        <div class="flex flex-col gap-4 sm:flex-row">
                            <RouterLink to="/contact" class="w-full sm:w-fit">
                                <button
                                    class="flex w-full items-center justify-center rounded-full border border-red-500 px-8 py-4 font-semibold uppercase tracking-[0.2em] text-red-200 transition hover:bg-red-500/20"
                                >
                                    <Phone class="mr-2" :size="18" /> Talk to our team
                                </button>
                            </RouterLink>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-white px-6 py-16 lg:px-20">
                <div class="mx-auto max-w-6xl">
                    <div class="mb-10 flex flex-col gap-4 text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.4em] text-blue-500">
                            Solutions
                        </p>
                        <h2 class="text-3xl font-bold text-slate-900 sm:text-4xl">
                            What we deliver to every identity journey
                        </h2>
                        <p class="text-lg text-slate-500">
                            Modeled after the Matica Group structure—refined for Azitsorog’s
                            all-in-one platform.
                        </p>
                    </div>
                    <div class="grid gap-6 md:grid-cols-2">
                        <article
                            v-for="pillar in solutionPillars"
                            :key="pillar.title"
                            class="rounded-2xl border border-slate-100 p-8 shadow-sm transition hover:-translate-y-1 hover:border-blue-300 hover:shadow-lg"
                        >
                            <h3 class="text-xl font-semibold text-slate-900">{{ pillar.title }}</h3>
                            <p class="mt-4 text-slate-600">
                                {{ pillar.body }}
                            </p>
                            <div class="mt-6 flex items-center text-blue-600">
                                <CircleArrowRight class="mr-2" :size="18" />
                                Learn more
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section class="bg-white px-6 py-16 lg:px-20">
                <div class="mx-auto flex max-w-6xl flex-col gap-12 lg:flex-row">
                    <div class="flex-1">
                        <p class="text-sm font-semibold uppercase tracking-[0.4em] text-blue-500">
                            Markets we secure
                        </p>
                        <h2 class="mt-4 text-3xl font-bold text-slate-900 sm:text-4xl">
                            Convergent solutions for every sector
                        </h2>
                        <p class="mt-4 text-lg text-slate-600">
                            From high-volume issuance bureaus to distributed enrollment sites, the
                            Azitsorog platform mirrors Matica’s ability to converge physical and
                            digital worlds without compromising trust.
                        </p>
                        <div class="mt-8 grid gap-6">
                            <div
                                v-for="market in markets"
                                :key="market.title"
                                class="rounded-2xl border border-slate-100 p-6 shadow-sm transition hover:border-blue-200"
                            >
                                <h3 class="text-xl font-semibold text-slate-900">
                                    {{ market.title }}
                                </h3>
                                <p class="mt-3 text-slate-600">
                                    {{ market.copy }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex-1 rounded-3xl bg-slate-950 p-10 text-white shadow-2xl"
                    >
                        <p class="text-sm font-semibold uppercase tracking-[0.4em] text-blue-200">
                            Convergent blueprint
                        </p>
                        <h3 class="mt-4 text-3xl font-bold">
                            Unified issuance, monitoring, and engagement.
                        </h3>
                        <p class="mt-4 text-slate-300">
                            We distilled Matica’s convergent systems narrative into actionable
                            guardrails for Azitsorog.
                        </p>
                        <ul class="mt-8 space-y-4">
                            <li
                                v-for="step in convergentSteps"
                                :key="step"
                                class="flex items-start text-slate-200"
                            >
                                <ArrowUpRight class="mr-3 mt-1 text-blue-300" :size="18" />
                                <span>{{ step }}</span>
                            </li>
                        </ul>
                        <RouterLink to="/contact" class="mt-10 block">
                            <button
                                class="flex w-full items-center justify-center rounded-full bg-blue-400 px-8 py-4 font-semibold text-slate-950 transition hover:bg-blue-300"
                            >
                                <Phone class="mr-2" :size="20" /> Plan a deployment
                            </button>
                        </RouterLink>
                    </div>
                </div>
            </section>

            <section class="bg-slate-900 px-6 py-16 text-white lg:px-20">
                <div class="mx-auto max-w-6xl">
                    <div class="mb-12 text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.4em] text-blue-300">
                            Matica hardware we distribute
                        </p>
                        <h2 class="mt-4 text-3xl font-bold sm:text-4xl">
                            Product showcase inspired by Matica Secure ID
                        </h2>
                        <p class="mt-4 text-lg text-slate-200">
                            Azitsorog focuses exclusively on Matica printers, engravers, and secure ID
                            solutions—mirroring the portfolio highlighted on the Secure ID page.
                        </p>
                    </div>
                    <div class="grid gap-6 md:grid-cols-2">
                        <article
                            v-for="product in products"
                            :key="product.name"
                            class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur transition hover:-translate-y-1 hover:border-blue-200/40"
                        >
                            <div class="flex flex-col gap-4 lg:flex-row">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm uppercase tracking-wide text-blue-200">
                                                {{ product.type }}
                                            </p>
                                            <h3 class="mt-1 text-2xl font-semibold text-white">
                                                {{ product.name }}
                                            </h3>
                                        </div>
                                        <div class="rounded-full bg-blue-400/20 p-3 text-blue-200">
                                            <CircleArrowRight :size="20" />
                                        </div>
                                    </div>
                                    <ul class="mt-6 space-y-3 text-slate-200">
                                        <li
                                            v-for="highlight in product.highlights"
                                            :key="highlight"
                                            class="flex items-start"
                                        >
                                            <CheckCircle2
                                                class="mr-3 mt-0.5 text-blue-300"
                                                :size="18"
                                            />
                                            <span>{{ highlight }}</span>
                                        </li>
                                    </ul>
                                    <RouterLink to="/contact" class="mt-6 block text-blue-300">
                                        Request specs →
                                    </RouterLink>
                                </div>
                                <div
                                    class="flex flex-1 items-center justify-center rounded-2xl bg-white/5 p-4"
                                >
                                    <img
                                        :src="productPlaceholder"
                                        :alt="`${product.name} preview`"
                                        class="h-40 w-full rounded-xl object-contain"
                                    />
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </section>


            <section class="bg-blue-600 px-6 py-16 text-white lg:px-20">
                <div class="mx-auto flex max-w-6xl flex-col gap-10 lg:flex-row lg:items-center">
                    <div class="flex-1 space-y-6">
                        <p class="text-sm font-semibold uppercase tracking-[0.4em] text-blue-200">
                            Ready for next steps
                        </p>
                        <h2 class="text-3xl font-bold sm:text-4xl">
                            Let’s issue, protect, and elevate every credential.
                        </h2>
                        <p class="text-lg text-blue-100">
                            Whether you’re modernizing ID printers, embedding fintech-grade cards, or
                            unifying enterprise access, our team carries the same trust-first DNA
                            showcased by Matica Group.
                        </p>
                    </div>
                    <div class="flex-1 rounded-3xl bg-white/10 p-8 backdrop-blur">
                        <div class="grid gap-6 md:grid-cols-2">
                            <div class="rounded-2xl bg-white/10 p-6">
                                <Handshake class="text-blue-100" :size="40" />
                                <p class="mt-4 text-4xl font-bold">488</p>
                                <p class="text-sm uppercase tracking-wide text-blue-200">
                                    Government facilities served
                                </p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-6">
                                <Building class="text-blue-100" :size="40" />
                                <p class="mt-4 text-4xl font-bold">580</p>
                                <p class="text-sm uppercase tracking-wide text-blue-200">
                                    Private enterprises supported
                                </p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-6">
                                <Landmark class="text-blue-100" :size="40" />
                                <p class="mt-4 text-4xl font-bold">68</p>
                                <p class="text-sm uppercase tracking-wide text-blue-200">
                                    Mission-critical programs
                                </p>
                            </div>
                            <div class="rounded-2xl bg-white/10 p-6">
                                <CircleArrowRight class="text-blue-100" :size="40" />
                                <p class="mt-4 text-4xl font-bold">24/7</p>
                                <p class="text-sm uppercase tracking-wide text-blue-200">
                                    Lifecycle support
                                </p>
                            </div>
                        </div>
                        <RouterLink to="/contact" class="mt-10 block">
                            <button
                                class="flex w-full items-center justify-center rounded-full bg-white px-8 py-4 font-semibold text-blue-700 transition hover:bg-blue-50"
                            >
                                <Phone class="mr-2 text-blue-600" :size="20" /> Contact us
                            </button>
                        </RouterLink>
                    </div>
                </div>
            </section>

        </main>
    </div>
</template>
