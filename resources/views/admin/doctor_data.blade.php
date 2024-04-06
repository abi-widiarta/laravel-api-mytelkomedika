@extends('layouts.layoutDashboardAdmin')

@section('content')
        <div class="flex flex-col h-full">
            <header class="flex items-center justify-between mb-4">
                <div class="flex items-start justify-start space-x-4">
                    <img src="/img/data-dokter-icon.png" alt="asd">
                    <h1 class="text-xl font-semibold">Data Dokter</h1>
                </div>
                <div class="relative flex items-center space-x-4">
                    @include('partials.dropdownProfile')
                </div>
            </header>

            <div class="flex flex-col flex-1 w-full p-6 bg-white rounded-xl">
                <h2 class="mb-8 text-lg font-semibold">Kelola Data Dokter</h2>
                <div class="flex justify-between mb-6">
                    <a href="/admin/data-dokter/create"
                        class="bg-[#ED1C24] text-sm px-4 py-2 font-semibold text-white rounded-full transition duration-150 hover:opacity-70">
                        Tambah Data
                    </a>
                    <div
                    class="flex justify-between text-sm border-2 border-gray-300 rounded-md focus:border-gray-600">
                        <form class="flex" action="/admin/data-dokter">
                            <input value="{{ request('search') }}" name="search" type="text" class="w-56 px-2 py-1.5 mr-2 border-red-500 outline-red-400" />
                            <button class="grid pr-2 transition-all duration-100 place-items-center hover:opacity-50" type="submit">
                                <img class="w-5" src="/img/icon-search.svg" alt="">
                            </button>
                        </form>
                    </div>
                </div>
                <div class="flex flex-col justify-between flex-1">

                    @if ($doctors->count() == 0)
                        <p class="text-sm font-medium text-center text-gray-500">Tidak ada data</p>
                    @else    
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
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Poli
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Jenis Kelamin
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center">
                                        Tanggal Lahir
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Alamat
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctors as $doctor)
                                    <tr class="bg-white border-b">
                                        <td scope="row" class="py-4 pl-4 pr-6">
                                            {{ ($doctors->currentPage() - 1) * $doctors->perPage() + $loop->iteration }}
                                        </td>
                                        <td scope="row" class="py-4 pl-2 pr-6">
                                            {{ $doctor->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $doctor->email }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $doctor->status == 1 ? 'Active' : 'Inactive' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ Str::ucfirst($doctor->specialization) }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            {{ $doctor->gender }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $doctor->birthdate }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $doctor->address }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a  
                                                    href="/admin/data-dokter/edit/{{ $doctor->username }}"
                                                    class="grid w-8 bg-gray-400 rounded-md place-items-center aspect-square hover:bg-gray-500">
                                                    <img src="/img/edit-icon.png" alt="edit-icon" />
                                                </a>
                                                <form class="doctor-delete-form" action="/admin/data-doctor/delete/{{ $doctor->id }}" method="POST">
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
                    @endif

                    <div class="mt-auto">
                        <div class="w-full mt-10">
                            {{ $doctors->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            const formDelete = document.querySelectorAll(".doctor-delete-form")

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