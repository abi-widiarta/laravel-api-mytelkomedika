@extends('layouts.layoutdashboard')

@section('content')
        {{-- @dd($daftar_pemeriksaan) --}}
        <div class="flex flex-col h-full">
            <header class="flex items-center justify-between mb-8">
                <div class="flex items-center justify-start space-x-4">
                    <img class="w-8" src="/img/riwayat-pemeriksaan-icon.png" alt="asd">
                    <h1 class="text-xl font-semibold">Riwayat Pemeriksaan</h1>
                </div>
                <div class="relative flex items-center space-x-4">
                    @include('partials.dropdownProfile')
                </div>
            </header>

            @if($daftar_pemeriksaan == [])
                <p class="mt-4 font-medium text-center text-gray-500">Tidak ada data</p>
            @else
                <div class="grid grid-cols-2 gap-6 w-[90%] mb-10">
                        @foreach ($daftar_pemeriksaan as $pemeriksaan)
                            <div class="flex justify-start py-6 pl-6 pr-10 space-x-4 transition-all duration-150 bg-white shadow-lg rounded-xl shadow-gray-100">
                                <div class="space-y-2 text-center">
                                    <img class="object-cover h-56 rounded-lg w-44" src="{{ $pemeriksaan['doctor']['image'] }}" alt="doctor-1" />
                                </div>
                                <span class="block w-[2px] bg-gray-200"></span>
                                <div class="flex flex-col justify-start flex-1">
                                    <h1 class="text-lg font-semibold text-gray-800">{{ $pemeriksaan['doctor']['name'] }}</h1>
                                    <p class="mb-3 text-sm font-medium text-gray-500">Poli {{ $pemeriksaan['doctor']['specialization'] }}</p>
                                    <div class="flex flex-col mb-5 space-y-2">
                                        <div class="flex items-center space-x-2">
                                            <p class="text-sm font-semibold text-gray-500">{{ \Carbon\Carbon::parse($pemeriksaan['date'])->locale('id')->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse($pemeriksaan['date'])->format('d-m-Y') }}</p>
                                        </div>
                                        
                                        @if ($pemeriksaan['report'] == null)
                                            <div class="flex items-center space-x-2">
                                                <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#1EC639]/10">
                                                    <img class="w-4" src="/img/loading-icon.png" alt="">
                                                </div>
                                                <p class="text-sm font-medium text-gray-500">Laporan pemeriksaan</p>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#1EC639]/10">
                                                    <img class="w-4" src="/img/loading-icon.png" alt="">
                                                </div>
                                                <p class="text-sm font-medium text-gray-500">Surat Sakit</p>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-2">
                                                <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#1EC639]/10">
                                                    <img class="w-4" src="/img/checklist-icon.png" alt="">
                                                </div>
                                                <p class="text-sm font-medium text-gray-500">Laporan pemeriksaan</p>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                    @if ($pemeriksaan['report']['sick_note'] == 1 )
                                                        <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#1EC639]/10">
                                                            <img class="w-4" src="/img/checklist-icon.png" alt="">
                                                        </div>
                                                    @else
                                                        <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#FDE2E3]">
                                                            <img class="w-4" src="/img/cross-icon.png" alt="">
                                                        </div>
                                                    @endif
                                                <p class="text-sm font-medium text-gray-500">Surat Sakit</p>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="flex justify-start w-full ">
                                    
                                        <a  
                                            href="/riwayat-pemeriksaan/detail?id={{ $pemeriksaan['id'] }}"
                                            class="py-3 font-medium px-10 text-white shadow-lg bg-gradient-to-r from-[#ED1C24]/90 to-[#ED1C24]/50 rounded-lg transition duration-200 hover:bg-[#ED1C24]">
                                            Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                </div>
            @endif
            {{-- <div class="w-full mt-auto">
                {{ $daftar_pemeriksaan->links() }}
            </div> --}}
        </div>
@endsection
