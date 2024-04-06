<!DOCTYPE html>
<html lang="eng">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyTelkomedika | Landing Page</title>
    {{-- fonts --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/assets/css/chat.min.css"> --}}

    {{-- tailwind css --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- flowbite --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>

</head>

<body>
    

    <nav class="fixed top-0 left-0 z-20 w-full px-5 shadow-lg bg-white/80 backdrop-blur-lg shadow-gray-100/50">
        <div class="flex flex-wrap items-center justify-between max-w-screen-xl p-4 mx-auto">
            <a href="/" class="flex items-center">
                <span
                    class="self-center text-xl md:text-2xl font-semibold whitespace-nowrap text-[#ED1C24]">MyTelkomedika</span>
            </a>
            <div class="flex md:hidden md:order-2">
                <button data-collapse-toggle="navbar-sticky" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-[#ED1C24] hover:text-white transition duration-150 focus:outline-none focus:ring-2 focus:ring-gray-200"
                    aria-controls="navbar-sticky" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                <ul
                    class="flex flex-col justify-center py-4 font-medium rounded-lg bg-gray-50 md:bg-transparent md:p-0 md:flex-row md:space-x-12 md:align-middle md:items-center">
                    <li class="relative">
                        <a href="/"
                            class="block py-2 transition duration-250 pl-3 pr-4 font-medium text-gray-900 md:hover:bg-transparent rounded md:bg-transparent md:p-0 md:hover:text-[#ED1C24] hover:bg-gray-100 md:border-0"
                            aria-current="page">Beranda</a>
                        <span
                            class="h-1 w-full {{ Request::is('/') ? 'md:block' : '' }}  hidden rounded bg-[#ED1C24] absolute"></span>
                    </li>
                    <li class="relative">
                        <a href="/contact"
                            class="block py-2 transition font-medium duration-250 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-[#ED1C24] md:p-0">Contact</a>
                        <span
                            class="h-1 w-full {{ Request::is('contact') ? 'md:block' : '' }}  hidden rounded bg-[#ED1C24] absolute"></span>
                    </li>
                    <li class="mt-5 md:mt-0">
                        <a href="/login"
                            class="text-white transition duration-300 shadow-lg hover:shadow-[#ED1C24]/40 text-base bg-[#ED1C24] rounded-full block md:px-7 py-2.5 text-center">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="mt-20">
        <section class="bg-white sm:px-5">
            <div class="flex flex-col max-w-screen-xl px-4 py-8 mx-auto md:flex-row lg:py-16">
                <div
                    class="flex flex-col items-center flex-1 order-2 mb-8 text-center rounded-lg md:order-1 md:items-start md:text-start">
                    <p class="text-[#ED1C24] text-base font-medium inline-flex items-center py-0.5 rounded-md mb-2">
                        Welcome to MyTelkomedika
                    </p>
                    <h1
                        class="text-gray-900 sm:text-4xl sm:max-w-md lg:max-w-md md:max-w-[16rem] text-3xl md:text-4xl md:leading-snug lg:text-6xl font-semibold lg:leading-tight mb-4">
                        One Stop Health Care For Telyutizen
                    </h1>
                    <p class="max-w-sm mb-6 text-sm font-normal text-gray-500 md:text-base">
                        Kamu meriang, ga enak badan? Tenang aja, ada Telkomedika
                        yang selalu siap mengobatimu!
                    </p>
                    <a href="#"
                        class="inline-flex text-sm transition duration-200 justify-center items-center shadow-lg shadow-[#ED1C24]/30 hover:shadow-[#ED1C24]/50 py-4 px-8 md:text-base rounded-full font-medium text-center text-white bg-[#ED1C24] mt-8 md:mt-0">
                        Baca Selengkapnya
                        <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>
                <div class="flex-1 order-1 md:order-2">
                    <img src="/img/hero.webp" alt="hero" />
                </div>
            </div>
        </section>

        <section class="bg-white">
            <div class="max-w-screen-xl px-8 mx-auto md:px-4">
                <div
                    class="bg-gradient-to-r shadow-lg shadow-[#ED1C24]/40 from-[#ED1C24] to-[#ED1C24]/60 rounded-tl-[60px] rounded-br-[60px] text-white px-6 sm:px-12 py-14 lg:p-16">
                    <ul
                        class="flex flex-col justify-between space-y-10 md:space-y-0 md:flex-row md:flex-wrap md:gap-y-10 md:justify-center md:gap-x-20">
                        <li class="flex items-center space-x-4">
                            <div
                                class="flex items-center justify-center p-4 border-2 border-white rounded-xl aspect-square bg-white/20">
                                <img class="w-12" src="/img/features-1.webp" alt="features-1" />
                            </div>
                            <div class="tracking-wide">
                                <p class="mb-1 font-semibold sm:text-xl md:text-xl">
                                    Pelayanan Gratis
                                </p>
                                <p class="sm:text-base md:text-sm text-xs md:max-w-[11rem]">
                                    Dengan membawa KTM dapatkan pelayanan gratis
                                </p>
                            </div>
                        </li>
                        <li class="flex items-center space-x-4">
                            <div
                                class="flex items-center justify-center p-4 border-2 border-white rounded-xl aspect-square bg-white/20">
                                <img class="w-12" src="/img/features-2.webp" alt="features-1" />
                            </div>
                            <div class="tracking-wide">
                                <p class="mb-1 font-semibold sm:text-xl md:text-xl">
                                    Dokter Terpercaya
                                </p>
                                <p class="sm:text-base md:text-sm text-xs md:max-w-[11rem]">
                                    Dilayani oleh dokter berintegritas dan
                                    terpercaya
                                </p>
                            </div>
                        </li>
                        <li class="flex items-center space-x-4">
                            <div
                                class="flex items-center justify-center p-4 border-2 border-white rounded-xl aspect-square bg-white/20">
                                <img class="w-12" src="/img/features-3.webp" alt="features-1" />
                            </div>
                            <div class="tracking-wide">
                                <p class="mb-1 font-semibold sm:text-xl md:text-xl">
                                    24 Jam
                                </p>
                                <p class="sm:text-base md:text-sm text-xs md:max-w-[11rem]">
                                    Siap melayani Telyutizen 24jam nonstop
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <img class="w-full" src="/img/wave-1.png" alt="" />

        <section class="bg-[#F3FBFF] md:-mt-10 pt-10 pb-48">
            <div class="max-w-screen-xl px-4 mx-auto text-center">
                <div class="mb-16 title md:mb-40">
                    <h1 class="mb-2 md:mb-4 text-2xl md:text-4xl font-bold tracking-tight leading-none text-[#ED1C24]">
                        Layanan Kami
                    </h1>
                    <span class="mx-auto w-32 h-0.5 md:w-64 md:h-1.5 bg-[#ED1C24] rounded-full block"></span>
                </div>

                <div
                    class="flex flex-col items-center services-card md:space-y-0 md:gap-y-10 space-y-14 md:flex-row md:flex-wrap md:justify-around">
                    <div class="max-w-[16rem] h-min bg-white border border-gray-200 rounded-xl shadow">
                        <img class="w-full rounded-t-lg" src="/img/service-1.webp" alt="" />
                        <div>
                            <div
                                class="bg-gradient-to-r relative z-10 -mt-4 py-5 px-5 rounded-xl from-[#ED1C24] to-[#F07A80]">
                                <h5 class="text-xl font-semibold tracking-normal text-white md:text-2xl">
                                    Poli Mata
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div
                        class="max-w-[16rem] lg:-translate-y-20 h-min bg-white border border-gray-200 rounded-xl shadow">
                        <img class="w-full rounded-t-lg" src="/img/service-2.webp" alt="" />
                        <div>
                            <div
                                class="bg-gradient-to-r relative z-10 -mt-4 py-5 px-5 rounded-xl from-[#ED1C24] to-[#F07A80]">
                                <h5 class="text-xl font-semibold tracking-normal text-white md:text-2xl">
                                    Poli Umum
                                </h5>
                            </div>
                        </div>
                    </div>

                    <div class="max-w-[16rem] h-min bg-white border border-gray-200 rounded-xl shadow">
                        <img class="w-full rounded-t-lg" src="/img/service-3.webp" alt="" />
                        <div>
                            <div
                                class="bg-gradient-to-r relative z-10 -mt-4 py-5 px-5 rounded-xl from-[#ED1C24] to-[#F07A80]">
                                <h5 class="text-xl font-semibold tracking-normal text-white md:text-2xl">
                                    Poli Gigi
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-[#263238]">
            <div class="w-full max-w-screen-xl mx-auto">
                <div class="py-16 md:flex md:justify-between">
                    <div class="flex items-center justify-center p-16 mb-6 text-white md:mb-0">
                        <a class="flex items-center">
                            <span class="self-center text-4xl font-medium whitespace-nowrap">MyTelkomedika</span>
                        </a>
                    </div>
                    <div class="flex justify-center">
                        <div class="flex flex-wrap px-16 gap-x-10 gap-y-10">
                            <div>
                                <h2 class="mb-2 text-xl font-semibold tracking-wider text-white">
                                    Address
                                </h2>
                                <p class="max-w-xs text-gray-300">
                                    Jl. Telekomunikasi Terusan Buah Batu,
                                    Bandung - 40257, Indonesia
                                </p>
                            </div>
                            <div class="flex flex-col space-y-10">
                                <div>
                                    <h2 class="mb-2 text-xl font-semibold tracking-wider text-white">
                                        Contact Us
                                    </h2>
                                    <div class="flex items-center space-x-4">
                                        <img src="/img/footer-mail.png" alt="icon-email" />
                                        <p class="text-gray-300">
                                            clove@telkomuniversity.ac.id
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <img src="/img/footer-phone.png" alt="icon-email" />
                                        <p class="text-gray-300">
                                            +62 888-8888-8888
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="mb-2 text-xl font-semibold tracking-wider text-white">
                                        Follow Us
                                    </h2>
                                    <div class="flex items-center space-x-4">
                                        <a href="#">
                                            <img src="/img/icon-ig.png" alt="footer-icon" />
                                        </a>
                                        <a href="#">
                                            <img src="/img/icon-fb.png" alt="footer-icon" />
                                        </a>
                                        <a href="#">
                                            <img src="/img/icon-twitter.png" alt="footer-icon" />
                                        </a>
                                        <a href="#">
                                            <img src="/img/icon-linkedin.png" alt="footer-icon" />
                                        </a>
                                        <a href="#">
                                            <img src="/img/icon-yt.png" alt="footer-icon" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </main>
    {{-- <script id="botmanWidget" src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/chat.js'></script>
    <script>
        var botmanWidget = {
            frameEndpoint: '/iFrameUrl'    
        };
        </script>
        <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script> --}}
</body>
</html>
