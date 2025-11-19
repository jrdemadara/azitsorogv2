<template>
    <footer class="bg-slate-950 text-slate-200">
        <div
            class="mx-auto flex max-w-6xl flex-col gap-8 px-6 py-12 lg:flex-row lg:items-center lg:justify-between"
        >
            <div class="space-y-3">
                <img src="../../images/logo-full.png" alt="Azitsorog" class="h-10 w-auto" />
                <p class="text-sm text-slate-400">
                    Authorized Matica distributor for printers, engravers, turnstiles, and support
                    across the Philippines.
                </p>
            </div>
            <div class="grid grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-blue-300">
                        Navigate
                    </p>
                    <ul class="mt-3 space-y-2 text-slate-300">
                        <li><RouterLink to="/" class="hover:text-white">Home</RouterLink></li>
                        <li><RouterLink to="/about" class="hover:text-white">About</RouterLink></li>
                        <li><RouterLink to="/contact" class="hover:text-white">Contact</RouterLink></li>
                    </ul>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.4em] text-blue-300">Contact</p>
                    <ul class="mt-3 space-y-2 text-slate-300">
                        <li>+63 (2) 8654 9712</li>
                        <li>Ortigas Ext., Cainta, Rizal</li>
                        <li>support@azitsorog.com</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mx-auto max-w-6xl px-6 pb-6">
            <p class="text-center text-xs text-slate-500">
                © {{ new Date().getFullYear() }} Azitsorog Inc. All rights reserved.
            </p>
        </div>
    </footer>
</template>
