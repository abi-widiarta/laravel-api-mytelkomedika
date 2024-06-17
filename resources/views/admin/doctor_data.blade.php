@extends('layouts.layout_dashboard_admin')

@section('content')
    <div class="flex flex-col h-full">
        <header class="flex items-center justify-between mb-4">
            <div class="flex items-start justify-start space-x-4">
                <img src="/img/data-dokter-icon.png" alt="asd">
                <h1 class="text-xl font-semibold">Data Dokter</h1>
            </div>
            <div class="relative flex items-center space-x-4">
                @include('partials.profile')
            </div>
        </header>

        <div class="flex flex-col flex-1 w-full p-6 bg-white rounded-xl">
            <h2 class="mb-8 text-lg font-semibold">Data Dokter</h2>

            <div class="flex flex-col justify-between flex-1">

                @if (count($doctors) == 0)
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doctors as $doctor)
                                <tr class="bg-white border-b">
                                    <td scope="row" class="py-4 pl-4 pr-6">
                                        {{ $loop->iteration }}
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
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                @endif
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