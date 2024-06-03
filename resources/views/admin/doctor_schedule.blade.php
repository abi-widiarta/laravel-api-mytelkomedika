@extends('layouts.layoutDashboardAdmin')

@section('content')
        <div class="flex flex-col h-full">
            <header class="flex items-center justify-between mb-4">
                <div class="flex items-center justify-start space-x-4">
                    <img class="w-8" src="/img/reservasi-saya-icon.png" alt="asd">
                    <h1 class="text-xl font-semibold">Jadwal Dokter</h1>
                </div>
                <div class="relative flex items-center space-x-4">
                    @include('partials.dropdownProfile')
                </div>
            </header>

            <div class="flex flex-col flex-1 w-full p-6 bg-white rounded-xl">
                <h2 class="mb-8 text-lg font-semibold">Kelola Jadwal Dokter</h2>
                <div class="flex justify-between mb-8">
                    <a href="/admin/jadwal-dokter/create"
                        class="bg-[#ED1C24] text-sm px-4 py-2 font-semibold text-white rounded-full transition duration-150 hover:opacity-70">
                        Tambah Data
                    </a>
                    <div
                        class="flex justify-between px-2 py-1 text-sm border-2 border-gray-300 rounded-md focus:border-gray-600">
                        <input type="text" class="w-56" />
                        <img class="w-5" src="/img/icon-search.svg" alt="">
                    </div>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase border-b">
                            <tr>
                                <th scope="col" class="py-3 pl-2 pr-6">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Poli
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Hari
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Jam Mulai
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Jam Selesai
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                                <tr class="bg-white border-b">
                                    <td scope="row" class="py-4 pl-4 pr-6">
                                        1
                                    </td>
                                    <td scope="row" class="px-6 py-4">
                                        {{ $schedule->doctor->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ Str::ucfirst($schedule->doctor->specialization) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ Str::ucfirst($schedule->day)  }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($schedule->schedule_time->start_hour)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($schedule->schedule_time->end_hour)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a
                                                href="/admin/jadwal-dokter/edit?id={{ $schedule->id }}"
                                                class="grid w-8 bg-gray-400 rounded-md place-items-center aspect-square hover:bg-gray-500">
                                                <img src="/img/edit-icon.png" alt="edit-icon" />
                                            </a>
                                            <form class="schedule-delete-form" action="/admin/jadwal-dokter/delete/{{ $schedule->id }}" method="POST">
                                                @csrf
                                                <button type="submit" class="grid w-8 bg-red-500 rounded-md place-items-center aspect-square hover:bg-red-600">
                                                    <img src="/img/delete-icon.png" alt="delete-icon" />
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="mt-auto">
                    <div class="w-full mt-10">
                        {{ $schedules->links() }}
                    </div>
                </div> --}}
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            const formDelete = document.querySelectorAll(".schedule-delete-form")

            formDelete.forEach(form => {
                form.addEventListener("submit", (e) => {
                e.preventDefault();
                
                Swal.fire({
                title: 'Warning',
                text: "Are you sure want to delete this data?",
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