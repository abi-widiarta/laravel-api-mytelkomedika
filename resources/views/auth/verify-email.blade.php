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

    {{-- tailwind css --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- flowbite --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .lottie {
          animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
        0% {
          transform: translatey(0px);
        }
        50% {
          transform: translatey(-20px);
        }
        100% {
          transform: translatey(0px);
        }
      }
    </style>
</head>

<body class="font-poppins">
    <nav
        class="fixed top-0 z-50 w-full border-gray-200 shadow-lg bg-white/80 backdrop-blur-lg sm:px-5 shadow-gray-100/50">
        <div class="max-w-screen-xl h-[70px] flex flex-wrap items-center justify-between mx-auto">
            <a href="/" class="flex items-center">
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-[#ED1C24]">MyTelkomedika</span>
            </a>
            <button data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-[#ED1C24] hover:text-white transition duration-150 focus:outline-none focus:ring-2 focus:ring-gray-200"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full mt-3 md:block md:w-auto md:mt-0" id="navbar-default"></div>
        </div>
    </nav>

    <section class="flex justify-center h-screen pt-8 bg-white">
      <div class="flex -mt-8 flex-col justify-center items-center wrapper w-[32rem]">

        {{-- <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script> --}}
        <lottie-player class="lottie" src="https://lottie.host/3fee85d2-6452-4bc5-b7da-6d70c52e144c/F8qzNjmfxz.json" background="#FFFFFF" speed="1" style="width: 300px; height: 300px" loop autoplay direction="1" mode="normal"></lottie-player>
        {{-- <lottie-player src="https://lottie.host/3fee85d2-6452-4bc5-b7da-6d70c52e144c/F8qzNjmfxz.json" background="#FFFFFF" speed="1" style="width: 300px; height: 300px" loop controls autoplay direction="1" mode="normal"></lottie-player> --}}
        {{-- <img class="mb-4  w-[90%]" src="/img/verify-email.jpg" alt=""> --}}
        <div class="mb-8 w-80">
          <h1 class="text-2xl font-semibold text-[#ED1C24] mb-3">Verify your email address</h1>
          <p class="text-sm text-center text-gray-600"> <strong>Please click on the link </strong>in  the email we just sent you to  verify your email address</p>
        </div>
        <form class="mb-6" action="/email/verification-notification" method="post">
          @csrf
          <button type="submit" class="text-white rounded-full bg-[#ED1C24] font-medium shadow-lg transition duration-200 hover:shadow-[#ED1C24]/50 shadow-[#ED1C24]/30 text-sm w-full sm:w-auto px-6 py-3 text-center active:opacity-50 active:translate-y-2 active:shadow-sm">
            Resend Email
          </button>
        </form>
        <p class="text-xs text-gray-500">Verification email has been sent</p>
        @if (session('message'))
          <p class="text-xs text-gray-500">{{ session('message') }}</p>
        @endif
      </div>
    </section>

    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>

</html>
