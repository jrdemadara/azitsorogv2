<script setup>
import {
    Phone,
    Mail,
    Download,
    Facebook,
    GaugeCircle,
    CircleArrowRight,
    Handshake,
    LandPlot,
    Landmark,
    Building,
    Printer,
    MapPin,
    MapPinHouse,
    Copy,
    Smartphone,
    MessageCircle,
    HandHeart,
} from "lucide-vue-next";
</script>

<template>
    <div class="flex justify-center items-center py-16 px-6 lg:px-32">
        <div class="flex flex-col justify-center items-center max-w-1/2">
            <h2 class="font-semibold text-4xl mb-6 text-blue-600">Get in Touch</h2>
            <div class="flex flex-col h-fit rounded-md shadow p-4 mb-5 w-full">
                <div class="flex items-center text-lg text-blue-600">
                    <MapPinHouse :size="20" /> <span>Visit us at:</span>
                </div>
                <a
                    href="https://www.google.com/maps/search/?api=1&query=No.+103+Gloria+St.+Corner+Ortigas+Ext.,+Marick+Subd.,+Cainta,+Rizal+Philippines+1900"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="font-semibold text-2xl mt-2 hover:text-blue-600"
                >
                    No. 103 Gloria St. Corner Ortigas Ext., Marick Subd., Cainta, Rizal Philippines
                    1900
                </a>
            </div>
            <div class="flex flex-col lg:flex-row justify-center w-full space-x-2">
                <div class="flex flex-col w-full h-fit rounded-md shadow p-4">
                    <div class="flex items-center text-lg mb-2 text-blue-600">
                        <MessageCircle class="mr-1" :size="20" />
                        <span>Call or Message us:</span>
                    </div>
                    <a
                        href="tel:+639199917747"
                        class="flex justify-between items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                    >
                        <h6 class="text-xl">+63 919 9917 747</h6>
                        <Smartphone :size="20" />
                    </a>

                    <a
                        href="tel:+639176763907"
                        class="flex justify-between items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                    >
                        <h6 class="text-xl">+63 917 676 3907</h6>
                        <Smartphone :size="20" />
                    </a>

                    <a
                        href="tel:+639176763907"
                        class="flex justify-between items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                    >
                        <h6 class="text-xl">+63 917 676 3907</h6>
                        <Smartphone :size="20" />
                    </a>

                    <a
                        href="tel:+639176763907"
                        class="flex justify-between items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                    >
                        <h6 class="text-xl">+63 917 676 3907</h6>
                        <Smartphone :size="20" />
                    </a>

                    <a
                        href="tel:+63289351542"
                        class="flex justify-between items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                    >
                        <h6 class="text-xl">+632 89351542</h6>
                        <Phone :size="20" />
                    </a>

                    <a
                        href="tel:+63289387214"
                        class="flex justify-between items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                    >
                        <h6 class="text-xl">+632 89387214</h6>
                        <Phone :size="20" />
                    </a>

                    <a
                        href="tel:+63289902306"
                        class="flex justify-between items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                    >
                        <h6 class="text-xl">+632 89902306</h6>
                        <Phone :size="20" />
                    </a>

                    <a
                        href="tel:+63286565899"
                        class="flex justify-between items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                    >
                        <h6 class="text-xl">+632 86565899</h6>
                        <Phone :size="20" />
                    </a>

                    <a
                        href="tel:+63284044187"
                        class="flex justify-between items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                    >
                        <h6 class="text-xl">+632 84044187</h6>
                        <Phone :size="20" />
                    </a>

                    <a
                        href="tel:+63284044834"
                        class="flex justify-between items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                    >
                        <h6 class="text-xl">+632 84044834</h6>
                        <Phone :size="20" />
                    </a>

                    <a
                        href="tel:+63286568605"
                        class="flex justify-between items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                    >
                        <h6 class="text-xl">+632 86568605</h6>
                        <Phone :size="20" />
                    </a>
                </div>
                <div class="flex flex-col w-full h-fit rounded-md shadow p-4 space-y-2">
                    <div class="flex flex-col h-fit p-4">
                        <div class="flex items-center text-lg text-blue-600">
                            <Mail class="mr-1" :size="20" /> <span>Email us:</span>
                        </div>
                        <a
                            href="mailto:president@azitsoroginc.com"
                            class="font-semibold text-xl mt-2 hover:text-blue-600"
                        >
                            president@azitsoroginc.com
                        </a>
                    </div>
                    <hr />
                    <div class="flex flex-col h-fit p-4">
                        <div class="flex items-center text-lg text-blue-600">
                            <Facebook class="mr-1" :size="20" />
                            <span>Message us:</span>
                        </div>
                        <a
                            target="_blank"
                            href="https://www.facebook.com/p/azitsorog-incorporated-100063541945604/"
                            class="font-semibold text-xl mt-2 hover:text-blue-600"
                        >
                            Azitsorog Inc. Official Facebook Page</a
                        >
                    </div>
                    <hr />
                    <div class="flex flex-col h-fit p-4">
                        <div class="flex items-center text-lg text-blue-600">
                            <HandHeart class="mr-1" :size="20" />
                            <span>Technical & Sales Support:</span>
                        </div>
                        <a
                            href="tel:+63286568605"
                            class="flex justify-between font-semibold items-center hover:bg-blue-500 mt-2 hover:text-white p-2 rounded"
                        >
                            <h6 class="text-xl">
                                <span class="font-normal">Luzon:</span> +63 917 516 2251
                            </h6>
                            <Smartphone :size="20" />
                        </a>
                        <a
                            href="tel:+639178060854"
                            class="flex justify-between font-semibold items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                        >
                            <h6 class="text-xl">
                                <span class="font-normal">Visayas:</span> +63 917 806 0854
                            </h6>
                            <Smartphone :size="20" />
                        </a>

                        <a
                            href="tel:+639998390945"
                            class="flex justify-between font-semibold items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                        >
                            <h6 class="text-xl">
                                <span class="font-normal">Mindanao:</span> +63 999 839 0945
                            </h6>
                            <Smartphone :size="20" />
                        </a>
                        <a
                            href="tel:0822246928"
                            class="flex justify-between font-semibold items-center hover:bg-blue-500 hover:text-white p-2 rounded"
                        >
                            <h6 class="text-xl">
                                <span class="font-normal">Mindanao:</span> 082 224 6928
                            </h6>
                            <Phone :size="20" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
