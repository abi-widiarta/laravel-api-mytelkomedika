@extends('layouts.layout_dashboard_doctor')

@section('content')
    <div class="flex flex-col h-full">
        <header class="flex items-center justify-between mb-4">
            <div class="flex items-center justify-start space-x-4">
                <h1 class="text-xl font-semibold">Dashboard</h1>
            </div>
            <div class="relative flex items-center space-x-4">
                <button class="relative transition-all duration-100 active:translate-y-1 active:shadow-sm" onclick="toggleDropdown()"> 
                    <div class="flex items-center bg-white p-2 md:space-x-4 md:px-4 shadow-[0px_7px_50px_0px_rgba(0,0,0,0.1)] rounded-xl">
                        <div class="flex items-center justify-center w-8 text-white bg-gray-600 rounded-full aspect-square">
                            <p class="inline-block">{{  Str::ucfirst($user['username'][0]) }}</p>
                        </div>
                        <div class="text-start md:block">
                            <p class="text-xs">{{ $user['name']  }}</p>
                            <p class="text-xs text-[#777A8F]">Dokter</p>
                        </div>
                    </div>
                    </button>
            </div>
        </header>
        
        <div class="flex flex-col flex-1 w-full p-6 bg-white rounded-xl">
            <div class="flex justify-between">
                <h2 class="mb-8 text-lg font-semibold">Antrian Pemeriksaan</h2>
                <div class="flex items-start space-x-2">
                    <form class="flex space-x-2" action="/dokter/antrian-pemeriksaan">
                        <input type="hidden" name="poli" value="{{ $user['specialization'] }}">
                        <div class="flex pr-2 items-center border border-gray-300 rounded-lg bg-white shadow-[0px_7px_61px_0px_rgba(198,203,232,0.5)]">
                            <input value="{{ request('tanggal_reservasi') }}" required name="tanggal_reservasi" autocomplete="off" class="text-gray-900 text-sm mr-2 rounded-md block w-full px-2 py-2 focus:outline-[#ED1C24]/50" id="datepicker" type="text">
                            <img class="w-5" src="/img/reservasi-saya-icon.png" alt="">
                        </div>
                        <button type="submit">Cari</button>
                    </form>
                </div>
            </div>

            @if ($reservations == [])
                <p class="mt-10 font-medium text-center text-gray-500">Tidak ada data</p>
            @else
                <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                    <thead class="text-xs text-gray-700 uppercase border-b">
                        <tr>
                            <th scope="col" class="py-3 pl-2 pr-6">
                                Nomor Antrian
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Pasien
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Jenis Kelamin
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jam
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                            <tr class="bg-white border-b">
                                <td scope="row" class="py-4 pl-2">
                                    {{ $reservation['queue_number'] }}
                                </td>
                                <td scope="row" class="px-6 py-4">
                                    {{ $reservation['patient']['name'] }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $reservation['patient']['email'] }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $reservation['patient']['gender'] }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $reservation['start_hour'])->format('H:i') }} - {{ \Carbon\Carbon::createFromFormat('H:i:s', $reservation['end_hour'])->format('H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            {{-- <div class="mt-auto">
                <div class="w-full mt-10">
                    {{ $reservations->links() }}
                </div>
            </div> --}}
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/datepicker.min.js"></script>
    <script>
        $(function () {
            $("#datepicker").datepicker({
                // minDate: 0, // Hanya hari ini atau setelahnya
            });
        });
    </script>
@endsection
