@extends('layouts.layoutdashboard')

@section('content')

        <div class="h-full">
            <header class="flex items-center justify-between mb-4">
                <div class="flex items-center justify-start space-x-4">
                    <h1 class="text-xl font-semibold">Dashboard</h1>
                </div>
                <div class="relative flex items-center space-x-4">
                   @include('partials.dropdownProfile')
                </div>
            </header>
            <div
                class="px-6 pt-6 pb-8 w-full bg-gradient-to-r from-[#ED1C24]/85 via-[#ED1C24]/85 to-[#ED1C24]/60 text-white rounded-xl shadow-[0px_25px_40px_-8px_#ee1c2536]">
                <h1 class="mb-2 text-xl font-semibold">
                    <div class="flex items-end space-x-2">
                        <p>Selamat Datang! {{ Auth::user()->name }}</p>
                        <img class="-mt-2" src="/img/popper.svg" alt="">
                    </div>
                </h1>
                <p class="text-sm font-normal">
                    Anda belum memiliki reservasi
                </p>
            </div>

            <div class="flex gap-8 mt-6">
                <div class="bg-white min-w-96 w-[70%] py-6 px-8 flex flex-col rounded-xl shadow-[0px_7px_50px_0px_rgba(198,203,232,0.25)]">
                    <h3 class="mb-4 text-lg font-semibold">Reservasi Saya</h3>
                    <div class="w-full mb-4">
                        <div class="flex w-full pb-2 font-medium border-b-2 border-slate-100">
                            <p class="w-[45%]">Dokter</p>
                            <p class="w-[20%] text-center">Tanggal</p>
                            <p class="w-[10%] text-center">Jam</p>
                            <p class="w-[25%] text-center">Nomor Antrian</p>
                        </div>
                    </div>
                    <div class="w-full space-y-2">
                        @if ($daftar_reservasi->total() == 0)
                            <p class="mt-4 text-sm font-medium text-center text-gray-600">Anda belum memiliki reservasi</p>
                        @else
                            @foreach ($daftar_reservasi as $reservasi)
                                    <div class="flex text-sm items-center rounded-lg bg-[#ecf5fc] shadow-[0px_7px_50px_0px_rgba(198,203,232,0.2)]">
                                            <div class="w-[45%] px-4 py-4 rounded-lg">
                                                <div class="flex space-x-4">
                                                    <div
                                                        class="w-10 aspect-square rounded-full overflow-hidden border-[3px] {{ $reservasi->doctor->specialization == 'umum' ? 'border-[#9FAEFF]' : ($reservasi->doctor->specialization == 'mata' ? 'border-[#FF0000]' : ($reservasi->doctor->specialization == 'gigi' ? 'border-[#55FF70]' : '')) }} ">
                                                        <img class="object-cover scale-110 aspect-square" src="{{ $reservasi->doctor->image }}">
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold">{{ $reservasi->doctor->name }}</p>
                                                        <p class="">Poli {{ Str::ucfirst($reservasi->doctor->specialization) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="w-[20%] px-4 py-4 text-center">
                                                {{ \Carbon\Carbon::parse($reservasi->date)->format('d-m-Y') }}
                                            </div>
                                            <div class="w-[10%] py-4 text-center">
                                                {{  \Carbon\Carbon::parse($reservasi->start_hour)->format('H:i') }}
                                            </div>
                                            <div class="w-[25%] py-4 text-center">
                                                {{ $reservasi->queue_number }}
                                            </div>
                                    </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="mt-auto">
                        <div class="w-full mt-10">
                            {{ $daftar_reservasi->links() }}
                        </div>
                    </div>
                </div>

                <div class="h-96 flex flex-col w-[30%]">
                    <div class="px-8 py-6 bg-white rounded-xl shadow-[0px_7px_50px_0px_rgba(198,203,232,0.2)]">
                        
                        <div class="flex items-start justify-between pb-4 mb-4 border-b-2 border-slate-100">
                            <h3 class="text-lg font-semibold">Antrian Poli</h3>
                            <div class="text-end">
                                <p class="text-xs font-medium text-gray-500">{{ $tanggal_hari_ini }}</p>
                                <p class="text-xs font-medium text-gray-500">{{  \Carbon\Carbon::parse($jam_mulai_hari_ini)->format('H:i') }} - {{  \Carbon\Carbon::parse($jam_selesai_hari_ini)->format('H:i') }}</p>
                            </div>
                        </div>
                        <div class="grid w-full grid-cols-3 gap-4">
                            <div>
                                <p class="mb-3 ml-1 text-sm font-medium">Umum</p>
                                <div class="flex flex-col items-start bg-[#FFE8E8] p-2 rounded-lg">
                                    <img class="w-6" src="/img/dashboard-admin-ticket-umum-icon.svg" alt="">
                                    <p class="font-bold text-[#FF5050] text-base">{{ $antrian_umum == '-' ? '-' : 'No ' . $antrian_umum }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="mb-3 ml-1 text-sm font-medium">Mata</p>
                                <div class="flex flex-col items-start bg-[#E8F8FF] p-2 rounded-lg">
                                    <img class="w-6" src="/img/dashboard-admin-ticket-mata-icon.svg" alt="">
                                    <p class="font-bold text-[#41B6FF] text-base">{{ $antrian_mata == '-' ? '-' : 'No ' . $antrian_mata }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="mb-3 ml-1 text-sm font-medium">Gigi</p>
                                <div class="flex flex-col items-start bg-[#DCFCE7] p-2 rounded-lg">
                                    <img class="w-6" src="/img/dashboard-admin-ticket-gigi-icon.svg" alt="">
                                    <p class="font-bold text-[#3CD755] text-base">{{ $antrian_gigi == '-' ? '-' : 'No ' . $antrian_gigi }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 px-8 py-6 mt-4 rounded-xl bg-white shadow-[0px_7px_50px_0px_rgba(198,203,232,0.25)]">
                        <h3 class="text-lg font-semibold">Pembayaran</h3>
                        <p class="mt-2 text-sm font-medium text-gray-500">Anda tidak memiliki pembayaran saat ini</p>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="pl-2 mb-4 text-lg font-semibold">Rekomendasi Dokter</h3>

                <div class="flex space-x-8">
                    @foreach ($recommended_doctors as $doctor)
                        <a href="/lakukan-reservasi/detail/{{ $doctor->username }}"
                            class="px-6 py-4 bg-white rounded-xl shadow-[0px_7px_50px_0px_rgba(198,203,232,0.25)] hover:-translate-y-1 hover:opacity-80 transition-all duration-150">
                            <div class="flex items-start justify-start space-x-4">
                                <img class="object-cover rounded-lg h-28 w-28" src="{{ $doctor->image }}" alt="">
                                <div class="flex flex-col justify-between flex-1 h-full ">
                                    <div>
                                        <p class="mb-2 text-sm font-semibold">{{ $doctor->name }}</p>
                                        <div class="flex items-center mb-2 space-x-1">
                                            <div class="p-1 bg-[#DCFCE7] rounded-full">
                                                <img src="/img/poli-icon-green.png" alt="" class="scr">
                                            </div>
                                            <p class="text-xs">Poli {{ Str::ucfirst($doctor->specialization) }}</p>
                                        </div>
                                        <div class="flex items-center mb-2 space-x-1">
                                            <div class="p-1 bg-[#DCFCE7] rounded-full">
                                                <img src="/img/review-icon-green.png" alt="" class="scr">
                                            </div>
                                            <p class="text-xs">{{ $doctor->review_total }} review </p>
                                        </div>
                                    </div>

                                    <div class="flex flex-1 space-x-2">
                                        <img src="/img/star-icon.png" alt="">
                                        <small class="font-semibold">{{ $doctor->rating }}</small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
@endsection
