<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { RouterLink, useRoute } from "vue-router";
import {
    Download,
    ChevronDown,
    BookOpen,
    Printer,
    Menu,
    X,
    PhoneCall,
    ArrowUpRight,
    ShieldCheck,
} from "lucide-vue-next";

const open = ref(false);
const mobileOpen = ref(false);
const dropdownRef = ref(null);
const route = useRoute();

const navLinks = [
    { label: "Home", to: "/" },
    { label: "About", to: "/about" },
    { label: "Contact", to: "/contact" },
];

const resourceLinks = [
    {
        label: "Printer Drivers",
        href: "https://www.maticagroup.com/downloads/",
        icon: Printer,
    },
    {
        label: "Brochures & Specs",
        href: "https://www.maticagroup.com/downloads/",
        icon: BookOpen,
    },
];

const handleClickOutside = (event) => {
    if (
        dropdownRef.value &&
        !dropdownRef.value.contains(event.target) &&
        !event.target.closest("[data-dropdown-trigger]")
    ) {
        open.value = false;
    }
};

onMounted(() => {
    document.addEventListener("click", handleClickOutside);
});
onBeforeUnmount(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>

<template>
    <header class="sticky top-0 z-50 w-full backdrop-blur">
        <div class="hidden border-b border-white/20 bg-slate-950/95 text-white lg:block">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-2 text-[0.7rem] uppercase tracking-[0.4em]">
                <div class="flex items-center gap-2">
                    <ShieldCheck :size="16" class="text-red-400" />
                    <span>Authorized Matica distributor</span>
                </div>
                <div class="flex items-center gap-6">
                    <a href="tel:+63286549712" class="flex items-center gap-2 hover:text-red-300">
                        <PhoneCall :size="14" />
                        +63 (2) 8654 9712
                    </a>
                    <span>Ortigas Ext, Cainta Rizal</span>
                </div>
            </div>
        </div>

        <div class="border-b border-slate-200 bg-white/95 shadow-sm">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 lg:px-6">
                <RouterLink to="/" class="flex items-center gap-3">
                    <img alt="Azitsorog logo" class="h-12 w-auto" src="../../images/logo-full.png" />
                </RouterLink>

                <nav class="hidden items-center gap-6 text-sm font-semibold text-slate-600 lg:flex">
                    <RouterLink
                        v-for="link in navLinks"
                        :key="link.to"
                        :to="link.to"
                        class="relative transition hover:text-red-500"
                        :class="{ 'text-red-600': route.path === link.to }"
                    >
                        {{ link.label }}
                        <span
                            v-if="route.path === link.to"
                            class="absolute -bottom-2 left-0 right-0 h-0.5 rounded-full bg-red-500"
                        ></span>
                    </RouterLink>
                    <div class="relative" ref="dropdownRef">
                        <button
                            data-dropdown-trigger
                            @click.stop="open = !open"
                            class="flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-slate-700 transition hover:border-red-400 hover:text-red-500"
                        >
                            <Download :size="16" />
                            Resources
                            <ChevronDown :size="18" />
                        </button>
                        <div
                            v-if="open"
                            class="absolute right-0 top-full mt-3 w-60 rounded-2xl border border-slate-100 bg-white p-3 shadow-2xl"
                        >
                            <a
                                v-for="item in resourceLinks"
                                :key="item.label"
                                :href="item.href"
                                target="_blank"
                                class="flex items-center gap-3 rounded-xl px-3 py-3 text-slate-600 transition hover:bg-red-50 hover:text-red-600"
                            >
                                <component :is="item.icon" :size="18" />
                                <span>{{ item.label }}</span>
                                <ArrowUpRight class="ml-auto" :size="16" />
                            </a>
                        </div>
                    </div>
                </nav>

                <div class="hidden items-center gap-3 lg:flex">
                    <RouterLink to="/contact">
                        <button
                            class="flex items-center gap-2 rounded-full bg-red-500 px-5 py-2 text-sm font-semibold uppercase tracking-wide text-white shadow-lg transition hover:bg-red-600"
                        >
                            <PhoneCall :size="16" />
                            Talk to our team
                        </button>
                    </RouterLink>
                </div>

                <button
                    @click="mobileOpen = !mobileOpen"
                    class="rounded-full border border-slate-200 p-2 text-slate-900 lg:hidden"
                >
                    <Menu v-if="!mobileOpen" :size="24" />
                    <X v-else :size="24" />
                </button>
            </div>
        </div>

        <transition name="fade">
            <div
                v-if="mobileOpen"
                class="lg:hidden border-b border-slate-200 bg-white px-4 pb-6 shadow-xl"
            >
                <div class="flex flex-col space-y-3 py-6">
                    <RouterLink
                        v-for="link in navLinks"
                        :key="link.to"
                        :to="link.to"
                        class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-red-300 hover:bg-red-50"
                        @click="mobileOpen = false"
                    >
                        {{ link.label }}
                    </RouterLink>
                    <div class="rounded-2xl border border-slate-200 p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.4em] text-slate-400">
                            Resources
                        </p>
                        <div class="mt-3 flex flex-col gap-2">
                            <a
                                v-for="item in resourceLinks"
                                :key="item.label"
                                :href="item.href"
                                target="_blank"
                                class="flex items-center gap-3 rounded-xl px-3 py-2 text-sm text-slate-600 transition hover:bg-red-50 hover:text-red-600"
                            >
                                <component :is="item.icon" :size="18" />
                                {{ item.label }}
                                <ArrowUpRight class="ml-auto" :size="14" />
                            </a>
                        </div>
                    </div>
                    <RouterLink to="/contact" @click="mobileOpen = false">
                        <button
                            class="flex w-full items-center justify-center gap-2 rounded-2xl bg-red-500 px-4 py-3 text-sm font-semibold uppercase tracking-wide text-white shadow-lg transition hover:bg-red-600"
                        >
                            <PhoneCall :size="16" />
                            Talk to our team
                        </button>
                    </RouterLink>
                </div>
            </div>
        </transition>
    </header>
</template>
