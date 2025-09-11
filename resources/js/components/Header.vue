<script setup>
import { ref, onMounted, onBeforeUnmount } from "vue";
import { RouterLink } from "vue-router";
import { Download, ChevronDown, BookOpen, Printer, Menu, X } from "lucide-vue-next";

const open = ref(false);
const mobileOpen = ref(false);
const dropdownRef = ref(null);

const handleClickOutside = (event) => {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
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
    <header class="flex flex-col w-full">
        <!-- Top bar -->
        <div class="flex justify-between items-center bg-blue-600 w-full h-10 px-4 lg:px-8">
            <div class="flex flex-row items-center w-fit">
                <span>🇵🇭</span>
                <small class="ml-2 text-xs lg:text-sm text-slate-50 whitespace-nowrap truncate">
                    No. 103 Gloria St. Corner Ortigas Ext., Marick Subd.,
                    <br class="block lg:hidden" />
                    Cainta, Rizal Philippines 1900
                </small>
            </div>
        </div>

        <!-- Nav bar -->
        <div class="flex justify-between w-full h-16 items-center px-4 lg:px-8 shadow-sm">
            <!-- Logo -->
            <div class="flex justify-start items-center p-2">
                <img alt="logo" class="mr-1 w-14 lg:w-16" src="../../images/logo.png" />
                <span class="font-black text-lg lg:text-xl">Azitsorog Inc.</span>
            </div>

            <!-- Desktop nav -->
            <nav
                class="hidden lg:flex grow justify-center items-center space-x-8 mr-12 text-slate-950 font-semibold"
            >
                <RouterLink class="hover:text-blue-500" to="/">Home</RouterLink>
                <RouterLink class="hover:text-blue-500" to="/contact">Contact us</RouterLink>
                <RouterLink class="hover:text-blue-500" to="/about">About us</RouterLink>
            </nav>

            <!-- Desktop Dropdown -->
            <div class="hidden lg:flex relative justify-end items-center" ref="dropdownRef">
                <button
                    @click="open = !open"
                    class="flex justify-center space-x-2 items-center px-4 h-12 rounded border-2 font-semibold border-black hover:bg-blue-500 hover:text-white hover:border-0"
                >
                    <Download :size="20" />
                    <span>Downloadables</span>
                    <ChevronDown :size="20" />
                </button>

                <!-- Dropdown menu -->
                <div
                    v-if="open"
                    class="absolute left-0 top-full w-48 bg-white border border-gray-200 rounded shadow-lg z-10"
                >
                    <a
                        href="https://www.maticagroup.com/downloads/"
                        target="_blank"
                        class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white"
                    >
                        <Printer class="mr-2" :size="16" />
                        Printer Drivers
                    </a>
                    <a
                        href="https://www.maticagroup.com/downloads/"
                        target="_blank"
                        class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white"
                    >
                        <BookOpen class="mr-2" :size="16" />
                        Brochures
                    </a>
                </div>
            </div>

            <!-- Mobile Hamburger -->
            <button
                @click="mobileOpen = !mobileOpen"
                class="lg:hidden p-2 text-slate-900 hover:text-blue-600"
            >
                <Menu v-if="!mobileOpen" :size="28" />
                <X v-else :size="28" />
            </button>
        </div>

        <!-- Mobile Menu -->
        <div
            v-if="mobileOpen"
            class="lg:hidden flex flex-col space-y-4 bg-white shadow-md px-6 py-4"
        >
            <RouterLink class="hover:text-blue-500 font-semibold" to="/" @click="mobileOpen = false"
                >Home</RouterLink
            >
            <RouterLink
                class="hover:text-blue-500 font-semibold"
                to="/contact"
                @click="mobileOpen = false"
                >Contact us</RouterLink
            >
            <RouterLink
                class="hover:text-blue-500 font-semibold"
                to="/about"
                @click="mobileOpen = false"
                >About us</RouterLink
            >

            <!-- Mobile Dropdown -->
            <div class="flex flex-col" ref="dropdownRef">
                <button
                    @click="open = !open"
                    class="flex justify-between items-center w-full px-2 py-2 rounded border border-gray-300 font-semibold hover:bg-blue-500 hover:text-white"
                >
                    <span class="flex items-center space-x-2">
                        <Download :size="20" />
                        <span>Downloadables</span>
                    </span>
                    <ChevronDown :size="20" />
                </button>

                <div
                    v-if="open"
                    class="flex flex-col mt-2 border border-gray-200 rounded bg-white shadow-lg"
                >
                    <a
                        href="https://www.maticagroup.com/downloads/"
                        target="_blank"
                        class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white"
                    >
                        <Printer class="mr-2" :size="16" />
                        Printer Drivers
                    </a>
                    <a
                        href="https://www.maticagroup.com/downloads/"
                        target="_blank"
                        class="flex items-center px-4 py-2 text-gray-700 hover:bg-blue-600 hover:text-white"
                    >
                        <BookOpen class="mr-2" :size="16" />
                        Brochures
                    </a>
                </div>
            </div>
        </div>
    </header>
</template>
