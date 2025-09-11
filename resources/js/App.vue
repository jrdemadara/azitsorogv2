<script setup lang="ts">
import { RouterView } from "vue-router";
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
</script>

<template>
    <div id="app" class="flex flex-col min-h-screen">
        <!-- Header -->
        <Header />

        <!-- Main Content (Router Pages) -->
        <main class="flex-1">
            <RouterView />
        </main>

        <!-- Footer -->
        <Footer />
    </div>
</template>
