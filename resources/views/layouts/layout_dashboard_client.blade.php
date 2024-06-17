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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- flowbite --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>      
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }


        .ui-datepicker {
            border-radius: 10px;
            box-shadow: 2px 7px 15px 8px rgba(208,208,208,0.1);
            -webkit-box-shadow: 2px 7px 15px 8px rgba(208,208,208,0.1);
            -moz-box-shadow: 2px 7px 15px 8px rgba(208,208,208,0.1);
            border: 1px solid rgba(0,0,0,0.1) !important;
        }

        .ui-datepicker-header {
            background-color: white;
            border: none;
            border-bottom: 1px solid rgba(0,0,0,0.2);
        }

        .ui-datepicker-calendar .ui-state-selectable a {
            background-color: #4caf50;
            color: #fff;
        }

        /* Gaya untuk tanggal yang tidak dapat dipilih */
        .ui-datepicker-calendar .ui-state-disabled a {
            background-color: #e57373;
            color: #fff;
        }

        .dropdown-open {
            opacity: 1 !important;
            pointer-events: auto !important;
            top: 3.5rem !important;
            /* transform: scale(1) !important; */
        }

        .btn-toggle{
            width: 60px;
            height: 60px;
            background-color: #E81C23;
            position: fixed;
            bottom: 20px;
            right: 30px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            cursor: pointer;
            transition: all 0.2s ease; 
            font-size: 16px;
            box-shadow: 0px 6px 27px -1px rgba(237, 28, 36, 0.39);
            }

            .btn-toggle div {
            position: absolute;
            }

            .btn-toggle div:first-child {
            opacity: 1;
            display: grid;
            place-items: center;
            transition: all 0.2s ease; 
            }

            .btn-toggle div:last-child {
            opacity: 0;
            display: grid;
            place-items: center;
            transition: all 0.2s ease; 
            }

            body.show-modal .btn-toggle {
            transform: rotate(90deg);
            transition: all 0.2s ease; 
            }

            body.show-modal .btn-toggle div:first-child {
            opacity: 0;
            transition: all 0.2s ease; 
            }

            body.show-modal .btn-toggle div:last-child {
            opacity: 1;
            transition: all 0.2s ease; 
            }

            .chatbot {
            position: fixed;
            width: 420px;
            /* height: 500px; */
            border-radius: 15px;
            bottom: 90px;
            right: 30px;
            background-color: white;
            overflow: hidden;
            transform: scale(0.5);
            opacity:0;
            pointer-events: none;
            transition: all 0.2s ease; 
            transform-origin: bottom right;
            box-shadow: 0 0 128px 0 rgba(0,0,0,0.1),
              0 32px 64px -48px rgba(0,0,0,0.5);
            }

            body.show-modal .chatbot {
            transform: scale(1);
            opacity:1;
            transform-origin: bottom right;
            transition: all 0.2s ease; 
            pointer-events : auto;
            }

            .chatbot header {
            text-align: center;
            padding: 12px 0;
            background-color: #ED1C24;
            color: white;
            font-size: 18px;
            font-weight: 600;
            }

            .chatbox-container {
            /* background-color: blue; */
            background-color: white;
            overflow-y: auto;
            height: 470px;
            padding: 0 20px;
            padding-bottom: 20px;
            margin-bottom: 50px;
            }

            .chatbot :where(.chatbox-container, textarea)::-webkit-scrollbar {
            width: 6px;
            }
            .chatbot :where(.chatbox-container, textarea)::-webkit-scrollbar-track {
            background: #fff;
            border-radius: 25px;
            }
            .chatbot :where(.chatbox-container, textarea)::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 25px;
            }

            .chat-list {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            margin-top: 20px;
            font-size: 14px;
            }
            
            .chat-list img {
                padding-left: 0.2px;
            }

            .chat-list.from-bot {
            justify-content: flex-start;
            }

            .img-hidden {
            opacity: 0;
            }

            .chat-list.from-bot.no-margin-top {
            margin-top: 4px;
            }

            .chat-list.from-user {
            flex-direction: row-reverse;
            justify-content: flex-start;
            }

            .chat-list div {
            width: 35px;
            aspect-ratio : 1/1;
            border-radius: 50%;
            background-color: #1EC639;
            display: grid;
            place-items: center;
            margin-top: 4px;
            } 

            .chat-list.from-bot p {
            display: block;
            background: #f2f2f2;
            padding: 12px 16px;
            border-radius: 0 10px 10px 10px;
            max-width: 80%;
            }

            .chat-list.from-bot p span {
            font-weight: 600;
            }

            .chat-list.from-user p {
            max-width: 80%;
            display: block;
            background: rgba(237, 28, 36,1);
            color: white;
            padding: 12px 16px;
            border-radius: 10px 10px 0 10px;
            }

            .input-container {
            display: flex;
            gap: 5px;
            position: absolute;
            bottom: 0;
            width: 100%;
            background: #fff;
            padding: 0 20px;
            border-top: 1px solid #ddd;
            }

        .input-container textarea {
            height: 50px;
            width: 100%;
            border: none;
            outline: none;
            resize: none;
            max-height: 120px;
            padding: 15px 15px 15px 0;
            font-size: 0.95rem;
            font-family: 'Poppins', sans-serif;
        }

        .input-container img {
            margin-top: 10px;
        }

        .option {
            display: flex;
            gap: 4px;
            flex-direction: column;
            align-items: flex-start;
            padding-left: 45px;
            margin-top: 4px
        }

        .option div {
            text-decoration: none;
            color: #1EC639;
            padding: 10px;
            border-radius: 10px;
            background-color: rgba(30, 198, 57,0.1);
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s ease; 
        }

        .option div:hover {
            opacity: 0.7;
            cursor: pointer;
            transition: all 0.2s ease; 
        }
        
        .send {
            cursor: pointer;
            transition: all 0.2s ease; 
        }

        .send:hover {
            opacity: 0.7;
            transition: all 0.2s ease; 
        }

        .disable-user-input {
            opacity: 0.3;
            pointer-events: none;
        }

        .pulse {
          animation: pulse 0.5s infinite ease-in-out alternate;
        }

        .flash {
          animation: flash 500ms ease infinite alternate;
        }
              
        @keyframes pulse {
            from { transform: scale(0.8); }
            to { transform: scale(1.2); }
        }

        @keyframes flash {
            from { opacity:1; }
            to { opacity:0; }
        }

        .hidden {
          visibility: hidden;
        }

        .tooltip-textarea {
          display: block;
          position: absolute;
          width: 400px;
          bottom: 60px;
          background-color: #FDE2E3;
          color: #ED1C24;
          font-size: 12px;
          padding: 8px 4px;
          border-radius: 8px 8px 8px 0;
          z-index: 999;
          text-align: center;
          left: 10px;
          transform: scale(0.5);
          opacity: 0;
          transform-origin: left bottom; 
          transition: all 0.2s ease; 
        }

        .tooltip-show {
          transform: scale(1);
          opacity: 1;
          transition: all 0.2s ease;
          transform-origin: left bottom; 
        }

        .input-container-overlay {
          position: absolute;
          bottom: 0;
          width: 100%;
          height: 56px;
          background-color: rgba(255, 255, 255,0.7);
          display: block;
          cursor:not-allowed;
        }

        .chat-in {
          animation: chat-in 400ms cubic-bezier(.47,1.64,.41,.8) forwards;
          animation-name: 1;
          transform-origin: bottom right;
        }

        @keyframes chat-in {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }


    </style>
    <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body>
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <main class="flex bg-[#F3FBFF] min-h-screen">
        {{-- sidebar --}}
        @include('partials.sidebar_client')
        
        {{-- main content --}}
        <section class="flex-1 px-8 py-6">
            @yield('content')
        </section>
    </main>
    <script src="./script.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
</body>
</html>
