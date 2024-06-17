@extends('layouts.layout_dashboard_client')

@section('content')
    <div class="flex flex-col h-full overflow-hidden">
        {{-- Header --}}
        <header class="flex items-center justify-between mb-8">
            <div class="flex items-center justify-start space-x-4">
                <img class="w-8" src="/img/riwayat-pemeriksaan-icon.png" alt="asd">
                <h1 class="text-xl font-semibold">Riwayat Pemeriksaan</h1>
            </div>
            <div class="relative flex items-center space-x-4">
                @include('partials.profile')
            </div>
        </header>
        
        {{-- Content --}}
        <div class="bg-white rounded-xl">
            
            {{-- Button Kembali --}}
            <a href="/lakukan-reservasi" class="inline-flex items-center justify-center mt-5 ml-4 transition-all duration-150 bg-gray-200 rounded-full hover:opacity-50 w-7 aspect-square">
                <img src="/img/chevron-back-icon.svg" alt="">
            </a>

            {{-- Detail Dokter--}}
            <div class="flex flex-1 items-stretch px-2.5 pt-3 pb-10 overflow-hidden ">
                
                {{-- Bagian Kiri --}}
                <div class="w-auto">
                    <img class="items-center object-cover h-56 mx-auto mb-4 rounded-lg w-44" src="{{ $data['doctor']['image'] }}" alt="doctor-1" />
                    <div class="mx-8">
                        <div class="flex flex-col justify-start flex-1">
                        <h1 class="mb-4 text-lg font-semibold">{{ $data['doctor']['name'] }}</h1>
                        <div class="flex flex-col mb-4 space-y-2">
                            <div class="flex items-center space-x-2">
                                <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#DCFCE7]">
                                    <img src="/img/poli-green.png" alt="">
                                </div>
                                <p class="text-sm font-medium text-gray-500">Poli {{ Str::ucfirst($data['doctor']['specialization']) }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#DCFCE7]">
                                    <img src="/img/patient-green.png" alt="">
                                </div>
                                <p class="text-sm font-medium text-gray-500">{{ $data['doctor']['patient_total'] }} pasien</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#DCFCE7]">
                                    <img src="/img/review-green.png" alt="">
                                </div>
                                <p class="text-sm font-medium text-gray-500">{{ $data['doctor']['review_total'] }} review</p>
                            </div>
                        </div>
                        <div class="flex items-center mb-6 space-x-1">
                            <p class="text-sm font-semibold">Rating : {{ $data['doctor']['rating'] }}</p>
                            <img src="/img/star-icon.png" alt="">
                        </div>
                        <div class="flex justify-start w-full">
                            @include('partials.modal_reservasi')
                        </div>
                        </div>
                    </div>
                </div>

                {{-- Divider --}}
                <span class="block w-[2px] bg-gray-200/50 mr-8"></span>
                
                {{-- Bagian Kanan --}}
                <div class="flex-1 ">

                {{-- Bagian Jadwal Dokter --}}
                <div class="mb-10">
                    {{-- judul --}}
                    <div class="flex items-center mb-4 space-x-2">
                    <img class="w-5" src="/img/jadwal-dokter-icon.svg" alt="">
                    <h1 class="text-sm font-medium">Jadwal Dokter</h1>
                    </div>
                    {{-- tabel --}}
                    <div class="relative overflow-x-auto w-[60%]">
                    <div class="flex pb-2">
                        <div class="w-[80%] font-medium text-sm text-left text-gray-500">
                        Hari
                        </div>
                        <div class="w-[20%] font-medium text-sm text-left text-gray-500">
                        Jam
                        </div>
                    </div>
                    <div class="flex flex-col">
                        @if ($data['schedules'] == [])
                            <div class="flex py-2.5 border-t">
                            <div class="w-[80%] text-sm text-left text-gray-500">
                                Belum memiliki jadwal
                            </div>
                            </div>
                        @else
                        @foreach ($data['schedules'] as $schedule)
                            @if ($schedule['day'] == 'senin')
                            <div class="flex py-2.5 border-t order-1">
                            @endif
                            @if ($schedule['day'] == 'selasa')
                            <div class="flex py-2.5 border-t order-2">
                            @endif
                            @if ($schedule['day'] == 'rabu')
                            <div class="flex py-2.5 border-t order-3">
                            @endif
                            @if ($schedule['day'] == 'kamis')
                            <div class="flex py-2.5 border-t order-4">
                            @endif
                            @if ($schedule['day'] == 'jumat')
                            <div class="flex py-2.5 border-t order-5">
                            @endif
                            @if ($schedule['day'] == 'sabtu')
                            <div class="flex py-2.5 border-t order-6">
                            @endif
                            @if ($schedule['day'] == 'minggu')
                            <div class="flex py-2.5 border-t order-7">
                            @endif
                                <div class="w-[80%] text-sm text-left text-gray-500">
                                    {{ Str::ucfirst($schedule['day']) }}
                                </div>
                                <div class="w-[20%] text-sm text-left text-gray-500 flex justify-between">
                                    <p>{{ \Carbon\Carbon::parse($schedule['schedule_time']['start_hour'])->format('H:i') }}</p>
                                    <p>-</p>
                                    <p>{{ \Carbon\Carbon::parse($schedule['schedule_time']['end_hour'])->format('H:i') }}</p>
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                    </div>
                </div>

                {{-- Bagian Review dokter --}}
                <div>
                    {{-- judul --}}
                    <div class="flex items-center mb-2 space-x-2">
                    <img class="w-6" src="/img/review-dokter-icon.svg" alt="">
                    <h1 class="text-sm font-medium">Review Terbaru</h1>
                    </div>
                    {{-- tabel --}}
                    <div>
                    @foreach ($data['reviews'] as $review)
                        <div class="flex items-start space-x-4 border-b w-[90%] pt-4 pb-4">
                        <div class="w-9 flex justify-center items-center aspect-square rounded-full bg-[#ED1C24]/10">
                            <img class="w-6" src="/img/thumb-up-icon.svg" alt="">
                        </div>
                        <div>
                            <p class="text-[#526069] font-medium mb-1 text-sm">{{ $review['report']['reservation']['patient']['name'] }}</p>
                            <div class="flex mb-2">
                            @for ($i = 0; $i < $review['rating']; $i++)
                                <img src="/img/star-icon.png" alt="">
                            @endfor
                            </div>
                            <p class="text-sm text-[#526069]">{{ $review['comment'] }}</p>
                        </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const formReservasi = document.querySelectorAll(".form-lakukan-reservasi")

        formReservasi.forEach(form => {
            form.addEventListener("submit", (e) => {
            e.preventDefault();
            
            Swal.fire({
            title: 'Warning',
            text: "Apakah semua data sudah benar?",
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
