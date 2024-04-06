@extends('layouts.layoutDashboardAdmin')

@section('content')
        {{-- @foreach ($schedule as $s)
            <p>{{ $s }}</p>
        @endforeach --}}
        <div class="flex flex-col h-full">
            <header class="flex items-center justify-between mb-4">
                <div class="flex items-center justify-start space-x-4">
                    <img class="w-8" src="/img/antrian-sidebar-icon.png" alt="asd">
                    <h1 class="text-xl font-semibold">Antrian Pemeriksaan</h1>
                </div>
                <div class="relative flex items-center space-x-4">
                    @include('partials.dropdownProfile')
                </div>
            </header>

            <div class="flex-1 w-full p-6 bg-white rounded-xl">
                <div class="flex justify-between mb-4">
                    <h2 class="text-lg font-semibold">Kelola Antrian Pemeriksaan</h2>
                    <div class="flex items-start space-x-2">
                        <form class="flex space-x-2" action="/admin/antrian-pemeriksaan">
                            <div>
                                <select required id="select-jam" name="poli" id="jam" class="block w-full p-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-primary/50">
                                    <option disabled>Pilih Poli</option>
                                    <option {{ request('poli') == 'umum' ? 'selected' : ''}} value="umum">Poli Umum</option>
                                    <option {{ request('poli') == 'mata' ? 'selected' : ''}} value="mata">Poli Mata</option>
                                    <option {{ request('poli') == 'gigi' ? 'selected' : ''}} value="gigi">Poli Gigi</option>
                                </select>
                            </div>
                            <div class="flex pr-2 items-center border border-gray-300 rounded-lg bg-white shadow-[0px_7px_61px_0px_rgba(198,203,232,0.5)]">
                                <input value="{{ request('tanggal_reservasi') }}" required name="tanggal_reservasi" autocomplete="off" class="text-gray-900 text-sm mr-2 rounded-md block w-full px-2 py-2 focus:outline-[#ED1C24]/50" id="datepicker" type="text">
                                <img class="w-5" src="/img/reservasi-saya-icon.png" alt="">
                            </div>
                            <div>
                                <select required id="select-jam" name="jam_mulai" id="jam" class="block w-full p-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg disabled:bg-slate-100 disabled:text-gray-500 focus:outline-primary/50">
                                    <option disabled>Pilih Jam</option>
                                    @foreach ($daftar_jam as $jam)
                                        <option {{ request('jam_mulai') == $jam->start_hour ? 'selected' : ''}} value="{{ $jam->start_hour }}">
                                            {{ \Carbon\Carbon::parse($jam->start_hour)->format('H:i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($jam->end_hour)->format('H:i') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit">Cari</button>
                        </form>
                    </div>
                </div>
                <div class="flex mb-8 space-x-2 text-sm">
                    <ul>
                        <li>Tanggal</li>
                        <li>Dokter Bertugas</li>
                        <li>Poli</li>
                    </ul>
                    <ul>
                        <li>:</li>
                        <li>:</li>
                        <li>:</li>
                    </ul>
                    <ul>
                        @if(request('tanggal_reservasi'))
                            <li>{{ request('tanggal_reservasi') }}</li>
                        @else
                            <li>{{ \Carbon\Carbon::now()->addHours(7)->format('Y-m-d')  }}</li>
                        @endif
                        @isset($reservations[0]->doctor->name)
                            <li>{{ $reservations[0]->doctor->name }}</li>
                        @endisset
                        @isset($reservations[0]->doctor->specialization)
                            <li>{{ Str::ucfirst($reservations[0]->doctor->specialization) }}</li>
                        @endisset
                    </ul>
                </div>
                <div class="flex flex-col justify-between flex-1">
                    <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase border-b">
                            <tr>
                                <th scope="col" class="py-3 pl-2 pr-6">
                                    Nomor <br> Antrian
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Pasien
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Jenis <br> Kelamin
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $reservation)
                                <tr class="border-b  {{  $reservation->status == 'completed' ? 'bg-green-100' : '' }}">
                                    <td scope="row" class="py-4 pl-4 pr-6">
                                        {{ $reservation->queue_number }}
                                    </td>
                                    <td scope="row" class="py-4 pl-2 pr-6">
                                        {{ $reservation->patient->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $reservation->patient->email }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $reservation->patient->gender }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $reservation->status }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <form class="flex space-x-2" action="/admin/antrian-pemeriksaan/complete/{{ $reservation->id }}" method="post">
                                                @csrf
                                                <button
                                                    {{  $reservation->status == 'completed' ? 'disabled' : '' }}
                                                    type="submit"
                                                    class="grid w-8 rounded-md place-items-center aspect-square disabled:opacity-50 hover:opacity-90">
                                                    <img src="/img/antrian-complete.png" alt="check-icon" />
                                                </button>
                                                <a
                                                    
                                                    href="/admin/antrian-pemeriksaan/hasil-pemeriksaan/{{ $reservation->id }}"
                                                    class="{{  $reservation->status != 'completed' ? 'pointer-events-none opacity-40' : '' }} grid w-8 transition-all duration-150 rounded-md place-items-center aspect-square hover:opacity-70">
                                                    <img src="/img/buat-laporan.png" alt="delete-icon" />
                                                </a>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    <div class="mt-auto">
                        <div class="w-full mt-10">
                            {{ $reservations->links() }}
                        </div>
                    </div>
                </div>  
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