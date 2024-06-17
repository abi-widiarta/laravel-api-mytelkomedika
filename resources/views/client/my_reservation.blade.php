@extends('layouts.layout_dashboard_client')

@section('content')
    <div class="h-full">
        {{-- Header --}}
        <header class="flex items-center justify-between mb-4">
            <div class="flex items-center justify-start space-x-4">
                <img class="w-8" src="/img/antrian-sidebar-icon.png" alt="asd">
                <h1 class="text-xl font-semibold">Reservasi Saya</h1>
            </div>
            <div class="relative flex items-center space-x-4">
                @include('partials.profile')
            </div>
        </header>

        {{-- Dropdown Poli --}}
        <div class="mb-4">
            {{-- button --}}
            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown-category" class="flex justify-between text-[#777A8F] focus:outline-[#777A8F] w-40 after:hidden bg-white border border-white/40 hover:bg-white/20 font-medium rounded-xl text-xs px-5 py-2.5 text-start items-center shadow-[0px_7px_61px_0px_rgba(198,203,232,0.5)] md:text-sm md:w-48" type="button">{{ request('poli') ? Str::ucfirst(request('poli')) : 'All'}}<svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
            </svg></button>
            <!-- menu -->
            <div id="dropdown-category" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-[0px_7px_61px_0px_rgba(198,203,232,0.5)] w-40 -translate-y-20 md:mt-0 md:w-44">
                <ul class="py-2 text-xs text-[#777A8F] md:text-sm" aria-labelledby="dropdownDefaultButton">
                    <li>
                        <a href="/reservasi-saya" class="block px-4 py-2 hover:bg-[#777A8F]/10">All</a>
                    </li>
                    <li>
                        <a href="/reservasi-saya/?poli=umum" class="block px-4 py-2 hover:bg-[#777A8F]/10">Poli Umum</a>
                    </li>
                    <li>
                        <a href="/reservasi-saya/?poli=mata" class="block px-4 py-2 hover:bg-[#777A8F]/10">Poli Mata</a>
                    </li>
                    <li>
                        <a href="/reservasi-saya/?poli=gigi" class="block px-4 py-2 hover:bg-[#777A8F]/10">Poli Gigi</a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- List Reservasi Saya--}}
        @if ($daftar_reservasi == [])
            <p class="w-full mt-4 text-sm font-medium text-center text-gray-500">Anda belum memiliki reservasi</p>
            
        @else
            <div class="grid grid-cols-2 gap-6">
                @foreach ($daftar_reservasi as $reservasi)
                    <div class="flex justify-start py-6 pl-6 pr-10 space-x-4 transition-all duration-150 bg-white shadow-lg rounded-xl shadow-gray-100">
                        <div class="space-y-2 text-center">
                            <img class="object-cover h-56 rounded-lg w-44" src="{{ $reservasi->doctor->image }}" alt="doctor-1" />
                        </div>
                        <span class="block w-[2px] bg-gray-200"></span>
                        <div class="flex flex-col justify-start flex-1">
                            <h1 class="text-lg font-semibold text-gray-800">{{ $reservasi->doctor->name }}</h1>
                            <p class="mb-3 text-sm font-medium text-gray-500">Poli {{ $reservasi->doctor->specialization }}</p>
                            <div class="flex flex-col mb-5 space-y-2">
                                <div class="flex items-center space-x-2">
                                    <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#1EC639]/10">
                                        <img src="/img/reservasi-saya-tanggal-icon.png" alt="">
                                    </div>
                                    <p class="text-sm font-medium text-gray-500">{{ \Carbon\Carbon::parse($reservasi->date)->locale('id')->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse($reservasi->date)->format('d-m-Y') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#1EC639]/10">
                                        <img src="/img/reservasi-saya-jam-icon.png" alt="">
                                    </div>
                                    <p class="text-sm font-medium text-gray-500">{{ \Carbon\Carbon::parse($reservasi->start_hour)->format('H:i') }} - {{ \Carbon\Carbon::parse($reservasi->end_hour)->format('H:i') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#1EC639]/10">
                                        <img src="/img/reservasi-saya-antrian-icon.png" alt="">
                                    </div>
                                    <p class="text-sm font-medium text-gray-500">Nomor Antrian :  {{ $reservasi->queue_number }}</p>
                                </div>
                            </div>
                            <div class="flex justify-start w-full ">
                                <form class="doctor-batalkan-reservasi" action="/reservasi-saya/cancel?id={{ $reservasi->id }}" method="POST">
                                    @csrf
                                    <button type="submit" class="py-3 text-sm text-white px-10 shadow-lg bg-gradient-to-r from-[#ED1C24]/90 to-[#ED1C24]/50 rounded-xl transition duration-200 hover:bg-[#ED1C24]">
                                        Batalkan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const formCancel = document.querySelectorAll(".doctor-batalkan-reservasi")

        formCancel.forEach(form => {
            form.addEventListener("submit", (e) => {
            e.preventDefault();
            
            Swal.fire({
            title: 'Warning',
            text: "Anda yakin akan membatalkan reservasi ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ED1C24',
            cancelButtonColor: '#C5C5C5',
            confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                form.submit();
                } 
            })
            })
        });
    </script>
@endsection
