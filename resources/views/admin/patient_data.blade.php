@extends('layouts.layout_dashboard_admin')

@section('content')
        <div class="flex flex-col h-full">
            <header class="flex items-center justify-between mb-4">
                <div class="flex items-start justify-start space-x-4">
                    <img src="/img/data-pasien-icon.png" alt="asd">
                    <h1 class="text-xl font-semibold">Data Pasien</h1>
                </div>
                <div class="relative flex items-center space-x-4">
                    @include('partials.profile')
                </div>
            </header>

            <div class="flex flex-col flex-1 w-full p-6 bg-white rounded-xl">
                <div class="flex items-start justify-between pr-6">
                    <h2 class="mb-8 text-lg font-semibold">Data Pasien</h2>
                    <div
                        class="flex justify-between text-sm border-2 border-gray-300 rounded-md focus:border-gray-600">
                        <form class="flex" action="/admin/data-pasien">
                            <input value="{{ request('search') }}" name="search" type="text" class="w-56 px-2 py-1.5 mr-2 border-red-500 outline-red-400" />
                            <button class="grid pr-2 transition-all duration-100 place-items-center hover:opacity-50" type="submit">
                                <img class="w-5" src="/img/icon-search.svg" alt="">
                            </button>
                        </form>
                    </div>
                </div>
                <div class="relative flex flex-col flex-1 overflow-x-auto">
                    @if ($patients == [])
                        <p class="mt-4 text-sm font-medium text-center text-gray-500">Tidak ada data</p>
                    @else
                        <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                            <thead class="text-xs text-gray-700 uppercase border-b">
                                <tr>
                                    <th scope="col" class="py-3 pl-2 pr-6">
                                        No
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nim
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Jenis Kelamin
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Tanggal Lahir
                                    </th>
                                    {{-- <th scope="col" class="px-6 py-3">
                                        Action
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $patient)
                                    <tr class="bg-white border-b">
                                        <td scope="row" class="py-4 pl-4 pr-6">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td scope="row" class="py-4 pl-2 pr-6">
                                            {{ $patient->student_id }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $patient->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $patient->email }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $patient->gender }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $patient->birthdate }}
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
        const formDelete = document.querySelectorAll(".patient-delete-form")

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


