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
} from "lucide-vue-next";
</script>

<template>
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        <header class="flex flex-col">
            <div class="flex justify-between items-center bg-blue-600 w-full h-10 px-8">
                <div class="flex flex-row w-fit space-x-4">
                    <span class="flex justify-center items-center text-slate-50">
                        <Phone class="mr-1" :size="16" /> +63 919-991-7747
                    </span>
                    <span class="flex justify-center items-center text-slate-50">
                        <Mail class="mr-1" :size="16" /> president@azitsoroginc.com
                    </span>
                    <span
                        class="flex justify-center items-center text-slate-50 hover:text-blue-300"
                    >
                        <a
                            target="_blank"
                            href="https://www.facebook.com/p/azitsorog-incorporated-100063541945604/"
                            class="flex justify-center items-center"
                        >
                            <Facebook :size="16" /> Azitsorog Inc.</a
                        >
                    </span>
                </div>
            </div>
            <div class="flex justify-between w-full h-16 items-center px-8 shadow">
                <div class="flex w-2/6 justify-start items-center p-2">
                    <img alt="logo" class="mr-1 w-20" src="../../images/logo.png" />
                    <span class="font-bold text-xl">Azitsorog Inc.</span>
                </div>
                <nav
                    class="grow flex justify-start items-center space-x-8 w-full mr-12 text-slate-950"
                >
                    <a class="text-lg hover:text-blue-600" href="/">Home</a>
                    <a class="text-lg hover:text-blue-600" href="#contact">Contact us</a>
                    <a class="text-lg hover:text-blue-600" href="#about">About</a>
                </nav>
                <div class="flex justify-end items-center space-x-5">
                    <a
                        href="https://www.maticagroup.com/downloads/"
                        target="_blank"
                        class="flex justify-center items-center w-48 px-4 h-12 rounded border-2 hover:bg-blue-600 hover:text-white border-blue-600"
                    >
                        <Download class="mr-2" :size="16" />
                        Printer Drivers
                    </a>
                    <a
                        href="https://www.maticagroup.com/downloads/"
                        target="_blank"
                        class="flex justify-center items-center w-48 px-4 h-12 rounded border-2 hover:bg-blue-600 hover:text-white border-blue-600"
                    >
                        <Download class="mr-2" :size="16" />
                        Brochures
                    </a>
                </div>
            </div>
        </header>

        <!-- Main content -->
        <main class="flex-grow">
            <section class="flex w-full h-fit px-32">
                <div class="flex flex-col justify-center items-start w-full">
                    <h2 class="font-bold text-6xl text-blue-600">Azitsorog Inc.</h2>
                    <h4 class="text-5xl text-slate-950 mt-6">
                        Unlock Efficiency: <br />
                        Harness the Power of RFID
                    </h4>
                    <a href="#contact">
                        <button
                            class="flex justify-center items-center w-44 h-14 mt-12 rounded font-medium text-slate-50 bg-blue-600"
                        >
                            <Phone class="mr-1" :size="24" /> Contact Us
                        </button>
                    </a>
                </div>
                <div class="flex justify-center items-center w-full py-20">
                    <img
                        alt="illustration"
                        class="mr-1"
                        src="../../images/printer2.png"
                        width="490"
                    />
                </div>
            </section>

            <section class="flex w-full h-fit p-28 bg-[#F9F9F9]">
                <div class="flex flex-col justify-center w-full space-y-2">
                    <h2 class="font-poppins text-3xl text-slate-800">What</h2>
                    <h2 class="font-bold text-3xl text-slate-800">We Deliver</h2>
                    <h2 class="text-3xl text-slate-800">To Our Clients</h2>
                </div>
                <div class="flex flex-col justify-center items-start w-full">
                    <div
                        class="flex justify-center items-center rounded-full w-20 h-20 bg-neutral-200"
                    >
                        <Printer class="text-slate-800" :size="38" />
                    </div>
                    <h2 class="font-bold text-lg text-slate-800 mt-3">Products</h2>
                    <p class="text-slate-600 mt-3">
                        High-quality ID card printers for all your identification needs.
                    </p>
                </div>
                <div class="flex flex-col justify-center items-start w-full">
                    <div
                        class="flex justify-center items-center rounded-full w-20 h-20 bg-neutral-200"
                    >
                        <GaugeCircle class="text-slate-800" :size="38" />
                    </div>
                    <h2 class="font-bold text-lg text-slate-800 mt-3">Management</h2>
                    <p class="text-slate-600 mt-3">
                        Comprehensive management solutions for seamless ID card printing operations.
                    </p>
                </div>
                <div class="flex flex-col justify-center items-start w-full">
                    <div
                        class="flex justify-center items-center rounded-full w-20 h-20 bg-neutral-200"
                    >
                        <Handshake class="text-slate-800" :size="38" />
                    </div>
                    <h2 class="font-bold text-lg text-slate-800 mt-3">Support</h2>
                    <p class="text-slate-600 mt-3">
                        Reliable and responsive support to ensure your ID card printers are always
                        running smoothly.
                    </p>
                </div>
            </section>

            <section class="flex flex-row-reverse w-full justify-start items-start h-fit p-28">
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
                    <a href="#contact">
                        <button
                            class="flex justify-center items-center w-44 h-14 mt-12 rounded font-medium text-slate-50 bg-blue-600"
                        >
                            <Phone class="mr-1" :size="24" /> Contact Us
                        </button>
                    </a>
                </div>
                <div class="flex justify-start w-full">
                    <img alt="turnstile" class="mr-1" src="../../images/printer2.png" width="480" />
                </div>
            </section>

            <section class="flex w-full h-fit p-28 bg-[#F9F9F9]">
                <div class="flex flex-col justify-center w-full">
                    <h2 class="text-4xl">Streamline Access Control with</h2>
                    <h2 class="font-bold text-4xl mt-1">Turnstile Solutions:</h2>
                    <p class="text-lg leading-loose mt-4 text-gray-500">
                        Empower Your Facility with Tailored Turnstile Solutions, <br />
                        Seamlessly Integrated with RFID Technology for <br />
                        Ultimate Access Control Precision.
                    </p>
                    <div class="flex flex-col mt-6 space-y-2">
                        <div class="flex items-center space-x-1">
                            <CircleArrowRight class="text-blue-500" :size="20" />
                            <p class="text-gray-500">
                                <span class="font-semibold">MultiAuth:</span> Flexible
                                authentication options for diverse access credentials.
                            </p>
                        </div>
                        <div class="flex items-center space-x-1">
                            <CircleArrowRight class="text-blue-500" :size="20" />
                            <p class="text-gray-500">
                                <span class="font-semibold">GuardGate:</span> Prevents unauthorized
                                access with advanced tailgating detection.
                            </p>
                        </div>
                        <div class="flex items-center space-x-1">
                            <CircleArrowRight class="text-blue-500" :size="20" />
                            <p class="text-gray-500">
                                <span class="font-semibold">DataInsight:</span> Analyzes access
                                patterns for enhanced security and efficiency.
                            </p>
                        </div>
                    </div>
                    <a href="#contact">
                        <button
                            class="flex justify-center items-center w-44 h-14 mt-12 rounded font-medium text-slate-50 bg-blue-600"
                        >
                            <Phone class="mr-1" :size="24" /> Contact Us
                        </button>
                    </a>
                </div>
                <div class="flex justify-center w-full">
                    <img
                        alt="turnstile"
                        class="mr-1"
                        src="../../images/turnstile.png"
                        width="500"
                    />
                </div>
            </section>

            <section class="flex flex-row-reverse w-full h-fit p-28">
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
                    <a href="#contact">
                        <button
                            class="flex justify-center items-center w-44 h-14 mt-12 rounded font-medium text-slate-50 bg-blue-600"
                        >
                            <Phone class="mr-1" :size="24" /> Contact Us
                        </button>
                    </a>
                </div>
                <div class="flex justify-start w-full">
                    <img alt="turnstile" class="mr-1" src="../../images/engraver.png" width="300" />
                </div>
            </section>

            <section
                id="contact"
                class="flex flex-col justify-center items-center py-32 bg-[#F9F9F9]"
            >
                <h2 class="font-semibold text-4xl mb-6 text-blue-600">Let's talk!</h2>
                <div class="flex justify-center space-x-8">
                    <div class="flex flex-col h-fit rounded-md shadow p-4">
                        <div class="flex items-center text-lg">
                            <Phone class="text-slate-800 mr-1" :size="24" />
                            <span>Call or Message us:</span>
                        </div>
                        <h6 class="font-bold text-2xl mt-2">+63 919 991 7747</h6>
                    </div>
                    <div class="flex flex-col h-fit rounded-md shadow p-4">
                        <div class="flex items-center text-lg">
                            <Mail class="text-slate-800 mr-1" :size="24" /> <span>Email us:</span>
                        </div>
                        <h6 class="font-bold text-2xl mt-2">president@azitsoroginc.com</h6>
                    </div>
                    <div class="flex flex-col h-fit rounded-md shadow p-4">
                        <div class="flex items-center text-lg">
                            <Facebook class="text-slate-800 mr-1" :size="24" />
                            <span>Message us:</span>
                        </div>
                        <a
                            target="_blank"
                            href="https://www.facebook.com/p/azitsorog-incorporated-100063541945604/"
                            class="font-bold text-2xl mt-2 hover:text-blue-600"
                        >
                            Azitsorog Inc.</a
                        >
                    </div>
                </div>
            </section>

            <section id="about" class="min-h-screen flex flex-col justify-center items-center">
                <div class="flex flex-col items-center text-center">
                    <img alt="logo" class="mb-4 mt-8" src="../../images/logo.png" width="100" />
                    <h2 class="font-bold text-2xl mb-6">Azitsorog Inc.</h2>
                    <div class="bg-white p-8 rounded-lg max-w-4xl">
                        <section id="about" class="mb-8">
                            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                                About Azitsorog Incorporated
                            </h1>
                            <p class="text-lg text-gray-700 leading-relaxed">
                                Azitsorog Incorporated is the leading distributor of Digital
                                Identification Card Printing System, RFID Access Control System,
                                Security Surveillance System, and manufacturer of ID Holder
                                Necklaces in the Philippines. Azitsorog Incorporated is the original
                                manufacturer of ID Holder Necklace with Full Color Logo Pin in the
                                world.
                            </p>
                        </section>

                        <section id="history" class="mb-8">
                            <h2 class="text-3xl font-semibold text-gray-900 mb-4">Our History</h2>
                            <p class="text-lg text-gray-700 leading-relaxed mb-4">
                                On July 17, 1993, AZITSOROG Trading emerged with a focus on
                                designing, manufacturing, and marketing innovative products that set
                                trends in various markets. Innovation has always been a key focus in
                                all the products and services Azitsorog Trading has introduced since
                                its inception in 1993.
                            </p>
                            <p class="text-lg text-gray-700 leading-relaxed mb-4">
                                In 1995, the Catholic Bishop Conference of the Philippines granted
                                Azitsorog an exclusive license to manufacture and distribute the
                                10th World Youth Day Unity Band globally. By 1998, the National
                                Centennial Commission also awarded Azitsorog an exclusive license to
                                create commemorative products for the Philippine Independence
                                Centennial celebration.
                            </p>
                            <p class="text-lg text-gray-700 leading-relaxed mb-4">
                                During the Jubilee Year 2000, Azitsorog gained another exclusive
                                license to manufacture and distribute Jubilee Commemorative Products
                                across the Philippines. These products included Jubilee Wrist Bands,
                                Notebooks, Alarm Clocks, and ID Holder Necklaces.
                            </p>
                            <p class="text-lg text-gray-700 leading-relaxed mb-4">
                                Building on its successes, Azitsorog diversified into distributing
                                Digital Identification Card Printing Systems, RFID Access Control
                                Systems, and Security Surveillance Systems, while also manufacturing
                                ID Accessories like ID Holder Necklaces with logo pins, Heavy Duty
                                Protectors, and Retractable ID Holders.
                            </p>
                            <p class="text-lg text-gray-700 leading-relaxed">
                                On January 16, 2002, the company was officially registered with the
                                Securities and Exchange Commission as Azitsorog Incorporated. Today,
                                Azitsorog Incorporated continues to focus on innovation and
                                technological advancements, ensuring excellent manufacturing,
                                marketing, and customer service practices for its clients.
                            </p>
                        </section>

                        <section id="philosophy">
                            <h2 class="text-3xl font-semibold text-gray-900 mb-4">
                                Our Philosophy
                            </h2>
                            <p class="text-lg text-gray-700 leading-relaxed">
                                In pursuit of maintaining our recognition in the domestic market,
                                Azitsorog Incorporated is dedicated to distributing state-of-the-art
                                Digital Identification Card Printing Systems, Security Surveillance
                                Systems, and high-quality Identification Card Accessories at
                                reasonable prices. We strive to meet or exceed customer expectations
                                through innovation and excellence in our products and services.
                            </p>
                        </section>
                    </div>
                </div>
            </section>

            <section class="flex w-full h-fit p-28 space-x-8 bg-blue-600">
                <div class="flex flex-col justify-center w-full">
                    <h2 class="text-4xl text-slate-50">Some Facts of Our</h2>
                    <h2 class="font-bold text-4xl mt-1 text-slate-50">Achievements Numbers</h2>
                    <p class="text-lg leading-loose mt-4 text-slate-200">
                        Exploring the significant achievements and impactful outcomes derived from
                        our successful collaborations with previous clients, underscoring our
                        commitment to excellence and client satisfaction.
                    </p>

                    <a href="#contact">
                        <button
                            class="flex justify-center items-center w-44 h-14 mt-12 rounded font-bold text-slate-900 bg-slate-50"
                        >
                            <Phone class="mr-1" :size="24" /> Contact Us
                        </button>
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-4 w-full h-fit justify-end">
                    <div class="flex flex-col w-100 h-100 rounded-xl p-8 space-y-2 bg-blue-500">
                        <Handshake class="mr-1 text-white" :size="58" />
                        <h2 class="font-bold text-5xl text-white">1,068</h2>
                        <p class="text-lg tracking-wider text-slate-300">Satisfied Clients</p>
                    </div>
                    <div class="flex flex-col w-100 h-100 rounded-xl p-8 space-y-2 bg-blue-500">
                        <LandPlot class="mr-1 text-white" :size="58" />
                        <h2 class="font-bold text-5xl text-white">48</h2>
                        <p class="text-lg tracking-wider text-slate-300">System Deployments</p>
                    </div>
                    <div class="flex flex-col w-100 h-100 rounded-xl p-8 space-y-2 bg-blue-500">
                        <Landmark class="mr-1 text-white" :size="58" />
                        <h2 class="font-bold text-5xl text-white">488</h2>
                        <p class="text-lg tracking-wider text-slate-300">Government Facilities</p>
                    </div>
                    <div class="flex flex-col w-100 h-100 rounded-xl p-8 space-y-2 bg-blue-500">
                        <Building class="mr-1 text-white" :size="58" />
                        <h2 class="font-bold text-5xl text-white">580</h2>
                        <p class="text-lg tracking-wider text-slate-300">Private Companies</p>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="flex justify-center items-center w-full h-fit py-2 bg-[#F9F9F9]">
            Copyright © 2024 Azitsorog Inc. All Rights Reserved.
        </footer>
    </div>
</template>
