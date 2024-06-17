@extends('layouts.layout_dashboard_client')

@section('content')
    <div class="h-full">
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
        <div class="flex items-stretch px-10 pb-10 mb-10 bg-white rounded-lg">
            {{-- Bagian Kiri --}}
            <div class="w-[30%] flex-col items-center">
                {{-- Foto Dokter --}}
                <img class="w-[212px] object-cover rounded-lg mt-8 items-center" src="{{ $report->reservation->doctor->image }}" alt="doctor-1" />
                
                {{-- Detail Dokter --}}
                <div class="pr-6 mt-3">

                    {{-- nama --}}
                    <h5 class="text-lg font-semibold">{{ $report->reservation->doctor->name }}</h5>
                    
                    {{-- statistik --}}
                    <div class="mt-2 mb-4 -ml-1 space-y-6">
                        <div class="flex flex-col mb-4 space-y-2">
                            {{-- poli --}}
                            <div class="flex items-center space-x-2">
                                <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#55FF70]/10">
                                    <img src="/img/poli-icon-green.png" alt="">
                                </div>
                                <p class="text-sm font-medium text-gray-500">Poli {{ Str::ucfirst($report->reservation->doctor->specialization) }}</p>
                            </div>
                            {{-- tanggal --}}
                            <div class="flex items-center space-x-2">
                                <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#55FF70]/10">
                                    <img src="/img/reservasi-saya-tanggal-icon.png" alt="">
                                </div>
                                <p class="text-sm font-medium text-gray-500">{{ $report->reservation->date }}</p>
                            </div>
                            {{-- pembayaran --}}
                            <div class="flex items-center space-x-2">
                                <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#55FF70]/10">
                                    <img class="w-4" src="/img/icon-wallet.png" alt="">
                                </div>
                                <div class="flex">
                                    <p class="text-sm font-medium text-gray-500">Rp. {{ $report->reservation->payment->amount }}</p>
                                    @if ($report->reservation->payment->amount != 0)
                                        <p class="text-sm font-medium text-gray-500">- {{ $report->reservation->payment->status == 1 ? 'Lunas' : 'Belum Lunas'  }}</span></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if ($report->sick_note == 1)
                            <div class="text-medium">
                                <a href="/riwayat-pemeriksaan/detail/pdf/{{ $report->reservation->id }}" class="inline-flex items-center w-auto space-x-2 transition-all duration-150 hover:cursor-pointer hover:opacity-70">
                                    <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#55FF70]/10">
                                        <img class="w-4 mx-auto" src="/img/checklist-icon.png" alt="checklist" />
                                    </div>
                                    <p class="text-sm font-medium text-gray-500">Surat Sakit</p>
                                    <img src="/img/download-icon.svg" alt="">
                                </a>
                            </div>
                        @else
                            <div data-tooltip-target="tooltip-light" data-tooltip-style="light" class="flex items-center space-x-2 transition-all duration-100 hover:cursor-pointer hover:opacity-70">
                                <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#ED1C24]/10">
                                    <img class="w-4 mx-auto" src="/img/cross-icon.png" alt="checklist" />
                                </div>
                                <p class="text-sm font-semibold text-gray-600">Surat Sakit</p>
                            </div>
                                
                            <div id="tooltip-light" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 tooltip">
                                Anda tidak eligible untuk mendapatkan surat keterangan sakit
                                <div class="tooltip-arrow" data-popper-arrow></div>
                            </div>
                        @endif
                    </div>
                    @include('partials.modal_review')
                </div>
            </div>

            {{-- Bagian Kanan --}}
            <div class="w-[70%]">
                <div class="bg-white w-full my-8 rounded-lg border-2 border-dashed border-[#3D9B35] py-4 px-6">
                    <div class="px-6 pt-4 pb-6 border-black border-dashed rounded-lg ">
                        <div class="items-center text-center">
                            <h5 class="mb-2 text-lg font-semibold text-gray-900 ">Kesimpulan Pemeriksaan</h5>
                        </div>
                        <span class="w-full my-3 mb-8 md:h-0.5 bg-[#DADADA] rounded-full block"></span>
                        <table class="h-full">
                            <tbody>
                                <tr class="flex mb-4">
                                    <td class="self-start block font-medium text-gray-600 min-w-40">Berat badan</td>
                                    <td>:</td>
                                    <td class="ml-4 ">{{ $report->weight }}</td>
                                </tr>
                                <tr class="flex mb-4">
                                    <td class="self-start block font-medium text-gray-600 min-w-40">Tinggi badan</td>
                                    <td>:</td>
                                    <td class="ml-4 ">{{ $report->height }}</td>
                                </tr>
                                <tr class="flex mb-4">
                                    <td class="self-start block font-medium text-gray-600 min-w-40">Suhu tubuh</td>
                                    <td>:</td>
                                    <td class="ml-4 ">{{ $report->temperature }}</td>
                                </tr>
                                <tr class="flex mb-4">
                                    <td class="self-start block font-medium text-gray-600 min-w-40">Keluhan</td>
                                    <td>:</td>
                                    <td class="ml-4 ">{{ $report->initial_complaint }}</td>
                                </tr>
                                <tr class="flex mb-4">
                                    <td class="self-start block font-medium text-gray-600 min-w-40">Diagnosa</td>
                                    <td>:</td>
                                    <td class="ml-4 ">{{ $report->diagnosis}}</td>
                                </tr>
                                <tr class="flex mb-4">
                                    <td class="self-start block font-medium text-gray-600 min-w-40">Anjuran</td>
                                    <td>:</td>
                                    <td class="ml-4 ">{{ $report->recommendations}}</td>
                                </tr>
                                <tr class="flex mb-4">
                                    <td class="self-start block font-medium text-gray-600 min-w-40">Obat</td>
                                    <td>:</td>
                                    <td class="ml-4 ">{{ $report->medications}}</td>
                                </tr>
                            </tbody>
                        </table>
                        
                        {{-- <div class="flex">
                            <ul class="list-none max-w-[30%]">
                                <li class="my-5 font-medium text-gray-600">Berat badan</li>
                                <li class="my-5 font-medium text-gray-600">Tinggi badan</li>
                                <li class="my-5 font-medium text-gray-600">Suhu tubuh</li>
                                <li class="my-5 font-medium text-gray-600">Keluhan</li>
                                <li class="my-5 font-medium text-gray-600">Diagnosa</li>
                                <li class="my-5 font-medium text-gray-600">Anjuran</li>
                            </ul>
                            <ul class="ml-12 mr-4 list-none max-w-[5%]">
                                <li class="my-5">:</li>
                                <li class="my-5">:</li>
                                <li class="my-5">:</li>
                                <li class="my-5">:</li>
                                <li class="my-5">:</li>
                                <li class="my-5">:</li>
                            </ul>
                            <ul class="list-none max-w-[65%]">
                                <li class="my-5 text-base text-gray-600">{{ $report->weight }} kg</li>
                                <li class="my-5 text-base text-gray-600">{{ $report->height }} cm</li>
                                <li class="my-5 text-base text-gray-600">{{ $report->temperature }} celcius</li>
                                <li class="my-5 text-base text-gray-600">{{ $report->initial_complaint }}</li>
                                <li class="my-5 text-base text-gray-600">{{ $report->diagnosis}}</li>
                                <li class="my-5 text-base text-gray-600">{{ $report->recommendations}}</li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
