<script setup>
import { RouterLink } from "vue-router";
import {
    Phone,
    GaugeCircle,
    CircleArrowRight,
    Handshake,
    LandPlot,
    Landmark,
    Building,
    Printer,
} from "lucide-vue-next";
</script>

<template>
    <div class="flex flex-col">
        <main class="flex-grow">
            <section class="flex flex-col lg:flex-row w-full h-fit px-2 lg:px-32 lg:mt-0 mt-10">
                <div class="flex flex-col justify-center items-center lg:items-start w-full">
                    <h2 class="font-bold text-2xl text-blue-500">Azitsorog Incorporated</h2>
                    <h4
                        class="text-6xl lg:text-7xl font-black lg:text-start text-center text-slate-950 mt-1"
                    >
                        AFTER WE SELL <br />
                        WE SERVE
                    </h4>
                    <RouterLink to="/contact">
                        <button
                            class="flex justify-center items-center w-44 h-14 mt-8 rounded font-bold text-white bg-blue-500 hover:bg-blue-600"
                        >
                            <Phone class="mr-1" :size="24" /> Contact Us
                        </button>
                    </RouterLink>
                </div>
                <div class="flex justify-center items-center w-full py-5 lg:py-20">
                    <img alt="illustration" src="../../images/background.png" width="1000" />
                </div>
            </section>

            <section
                class="flex lg:flex-row flex-col w-full h-fit p-6 lg:p-28 lg:spacey-0 space-y-5 bg-[#F9F9F9]"
            >
                <div
                    class="flex flex-col justify-center items-center lg:items-start w-full space-y-2"
                >
                    <h2 class="font-poppins text-3xl text-slate-800">What</h2>
                    <h2 class="font-bold text-3xl text-slate-800">We Deliver</h2>
                    <h2 class="text-3xl text-slate-800">To Our Clients</h2>
                </div>
                <div class="flex flex-col justify-center items-center lg:items-start w-full">
                    <div
                        class="flex justify-center items-center rounded-full w-20 h-20 bg-neutral-200"
                    >
                        <Printer class="text-slate-800" :size="38" />
                    </div>
                    <h2 class="font-bold text-lg text-slate-800 mt-3">Products</h2>
                    <p class="text-slate-600 mt-3 lg:text-start text-center">
                        High-quality ID card printers for all your <br />
                        identification needs.
                    </p>
                </div>
                <div class="flex flex-col justify-center items-center lg:items-start w-full">
                    <div
                        class="flex justify-center items-center rounded-full w-20 h-20 bg-neutral-200"
                    >
                        <GaugeCircle class="text-slate-800" :size="38" />
                    </div>
                    <h2 class="font-bold text-lg text-slate-800 mt-3">Management</h2>
                    <p class="text-slate-600 mt-3 lg:text-start text-center">
                        Comprehensive management solutions for <br />
                        seamless ID card printing operations.
                    </p>
                </div>
                <div class="flex flex-col justify-center items-center lg:items-start w-full">
                    <div
                        class="flex justify-center items-center rounded-full w-20 h-20 bg-neutral-200"
                    >
                        <Handshake class="text-slate-800" :size="38" />
                    </div>
                    <h2 class="font-bold text-lg text-slate-800 mt-3">Support</h2>
                    <p class="text-slate-600 mt-3 lg:text-start text-center">
                        Reliable and responsive support to ensure your <br />
                        ID card printers are always running smoothly.
                    </p>
                </div>
            </section>

            <section
                class="flex flex-col-reverse lg:space-y-0 lg:flex-row-reverse w-full justify-start items-start h-fit p-6 lg:p-28"
            >
                <div class="flex flex-col justify-center w-full">
                    <h2 class="text-4xl">Enhance ID Card Issuance:</h2>
                    <h2 class="font-bold text-4xl mt-1">ID Card Printing Solutions:</h2>
                    <p class="text-lg leading-loose mt-4 text-gray-500">
                        Equip Your Organization with Customized ID Card Printing Solutions,
                        Seamlessly Integrated with Advanced Printing and Encoding Technology for
                        Ultimate Credential Management.
                    </p>
                    <div class="flex flex-col mt-6 space-y-2">
                        <div class="flex items-center space-x-1">
                            <CircleArrowRight class="text-blue-500" :size="20" />
                            <p class="text-gray-500">
                                <span class="font-semibold">MultiPrint:</span> Flexible printing
                                options for diverse ID card designs and formats.
                            </p>
                        </div>
                        <div class="flex items-center space-x-1">
                            <CircleArrowRight class="text-blue-500" :size="20" />
                            <p class="text-gray-500">
                                <span class="font-semibold">SecureEncode:</span> Ensures data
                                integrity with advanced encoding and encryption.
                            </p>
                        </div>
                        <div class="flex items-center space-x-1">
                            <CircleArrowRight class="text-blue-500" :size="20" />
                            <p class="text-gray-500">
                                <span class="font-semibold">CardInsight:</span> Analyzes card
                                issuance patterns for improved efficiency and security.
                            </p>
                        </div>
                    </div>
                    <RouterLink to="/contact">
                        <button
                            class="flex justify-center items-center w-full lg:w-44 h-14 mt-12 rounded font-bold text-white bg-blue-500 hover:bg-blue-600"
                        >
                            <Phone class="mr-1" :size="24" /> Contact Us
                        </button>
                    </RouterLink>
                </div>
                <div class="flex justify-start w-full lg:mb-0 mb-5">
                    <img
                        alt="turnstile"
                        class="mr-0 lg:mr-1"
                        src="../../images/printer2.png"
                        width="480"
                    />
                </div>
            </section>

            <section
                class="flex lg:flex-row flex-col-reverse w-full h-fit p-6 lg:mt-0 mt-6 lg:p-28 bg-[#F9F9F9]"
            >
                <div class="flex flex-col justify-center w-full">
                    <h2 class="text-4xl">Revolutionize Engraving:</h2>
                    <h2 class="font-bold text-4xl mt-1">Engraving Solutions</h2>
                    <p class="text-lg leading-loose mt-4 text-gray-500">
                        Empower Your Organization with Customized Laser Engraving Solutions,
                        Designed for Precision, Efficiency, and Security.
                    </p>
                    <div class="flex flex-col mt-6 space-y-2">
                        <div class="flex items-center space-x-1">
                            <CircleArrowRight class="text-blue-500" :size="20" />
                            <p class="text-gray-500">
                                <span class="font-semibold">MultiEngrave:</span> Versatile engraving
                                options for a wide range of materials and designs.
                            </p>
                        </div>
                        <div class="flex items-center space-x-1">
                            <CircleArrowRight class="text-blue-500" :size="20" />
                            <p class="text-gray-500">
                                <span class="font-semibold">SecureMark:</span> Ensures durability
                                and tamper-resistant markings with advanced laser technology.
                            </p>
                        </div>
                        <div class="flex items-center space-x-1">
                            <CircleArrowRight class="text-blue-500" :size="20" />
                            <p class="text-gray-500">
                                <span class="font-semibold">EngraveInsight:</span> Analyzes
                                engraving patterns for optimized performance and efficiency.
                            </p>
                        </div>
                    </div>
                    <RouterLink to="/contact">
                        <button
                            class="flex justify-center items-center w-full lg:w-44 h-14 mt-12 rounded font-bold text-white bg-blue-500 hover:bg-blue-600"
                        >
                            <Phone class="mr-1" :size="24" /> Contact Us
                        </button>
                    </RouterLink>
                </div>
                <div class="flex justify-center w-full">
                    <img alt="turnstile" class="mr-1" src="../../images/engraver.png" width="300" />
                </div>
            </section>

            <section
                class="flex flex-col lg:flex-row w-full h-fit p-6 lg:p-28 justify-center items-center space-y-8 lg:space-y-0 lg:space-x-8 bg-blue-500"
            >
                <div class="flex flex-col justify-center w-full">
                    <h2 class="text-4xl text-slate-50">Some Facts of Our</h2>
                    <h2 class="font-bold text-4xl mt-1 text-slate-50">Achievements Numbers</h2>
                    <p class="text-lg leading-loose mt-4 text-slate-200">
                        Exploring the significant achievements and impactful outcomes derived from
                        our successful collaborations with previous clients, underscoring our
                        commitment to excellence and client satisfaction.
                    </p>

                    <RouterLink to="/contact">
                        <button
                            class="flex justify-center items-center w-full lg:w-44 h-14 mt-12 rounded font-bold text-slate-900 bg-slate-50 hover:bg-slate-100"
                        >
                            <Phone class="mr-1" :size="24" /> Contact Us
                        </button>
                    </RouterLink>
                </div>
                <div class="grid lg:grid-cols-2 gap-4 w-full h-fit lg:justify-end">
                    <div class="flex flex-col w-100 h-100 rounded-xl p-8 space-y-2 bg-blue-400">
                        <Handshake class="mr-1 text-white" :size="58" />
                        <h2 class="font-bold text-5xl text-white">1,068</h2>
                        <p class="text-lg tracking-wider text-slate-300">Satisfied Clients</p>
                    </div>
                    <div class="flex flex-col w-100 h-100 rounded-xl p-8 space-y-2 bg-blue-400">
                        <LandPlot class="mr-1 text-white" :size="58" />
                        <h2 class="font-bold text-5xl text-white">48</h2>
                        <p class="text-lg tracking-wider text-slate-300">System Deployments</p>
                    </div>
                    <div class="flex flex-col w-100 h-100 rounded-xl p-8 space-y-2 bg-blue-400">
                        <Landmark class="mr-1 text-white" :size="58" />
                        <h2 class="font-bold text-5xl text-white">488</h2>
                        <p class="text-lg tracking-wider text-slate-300">Government Facilities</p>
                    </div>
                    <div class="flex flex-col w-100 h-100 rounded-xl p-8 space-y-2 bg-blue-400">
                        <Building class="mr-1 text-white" :size="58" />
                        <h2 class="font-bold text-5xl text-white">580</h2>
                        <p class="text-lg tracking-wider text-slate-300">Private Companies</p>
                    </div>
                </div>
            </section>
        </main>
    </div>
</template>
