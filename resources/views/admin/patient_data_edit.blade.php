@extends('layouts.layoutDashboardAdmin')

@section('content')
        <div class="flex flex-col h-full">
            <header class="flex items-center justify-between mb-4">
                <div class="flex items-start justify-start space-x-4">
                  <img src="/img/data-pasien-icon.png" alt="asd">
                  <h1 class="text-xl font-semibold">Data Pasien</h1>
                </div>
                <div class="relative flex items-center space-x-4">
                    @include('partials.dropdownProfile')
                </div>
            </header>

            <div class="relative flex-1 w-full p-6 pt-8 bg-white rounded-xl">
              <a class="inline-block px-3 py-2 mb-2 text-white transition-all duration-150 bg-gray-400 rounded-full hover:shadow-md active:translate-y-1" href="/admin/data-pasien">
                <div class="flex space-x-2 text-sm">
                  <p>◀</p>
                  <p>Kembali</p>
                </div>
              </a>
                <h2 class="mb-8 text-lg font-semibold text-center">Edit Data Pasien</h2>
                {{-- <div class="flex flex-col items-center w-full mt-2 mb-7">
                  <div class="flex items-center justify-center mb-2 rounded-full shadow-md w-14 aspect-square bg-slate-400">
                    <h1 class="text-4xl text-white">{{ Auth::user()->name[0] }}</h1>
                  </div>
                  <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                  <p class="text-xs">Student</p>
                </div> --}}
                <div class="flex w-full">
                  <form id="update-form" class="flex flex-col items-center w-full bg-gray" method="POST" action="/admin/data-pasien/update/{{ $patient->id }}}">
                    @csrf
                    <div class="flex space-x-8 w-[80%] mb-4">
                      <div class="w-full">
                        <div class="mb-6">
                            <input type="hidden" name="username" value="{{ $patient->username }}">
                          <label
                              for="nim"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Nim</label
                          >
                          <input
                              type="text"
                              id="nim"
                              name="nim"
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              value="{{ $patient->student_id }}"
                              disabled
                              required
                          />
                        </div>
                        <div class="mb-6">
                          <label
                              for="name"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Nama</label
                          >
                          <input
                              type="text"
                              id="name"
                              name="name"
                              value="{{ $patient->name }}"
                              disabled
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              required
                          />
                        </div>
                        <div class="mb-6">
                          <label
                              for="username"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Username</label
                          >
                          <input
                              type="text"
                              id="username"
                              name="username"
                              value="{{ $patient->username }}"
                              disabled
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              required
                          />
                        </div>
                        <div class="mb-6">
                          <label
                              for="email"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Email</label
                          >
                          <input
                              type="email"
                              id="email"
                              name="email"
                              value="{{ $patient->email }}"
                              disabled
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              required
                          />
                        </div>
                        <div class="mb-6">
                          <label
                              for="email"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Password</label
                          >
                          <input
                              type="password"
                              id="password"
                              name="password"
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                          />
                        </div>
                      </div>
  
                      <span class="block w-0.5 bg-gray-300 h-[28rem]"></span>
  
                      <div class="w-full">
                        <div class="mb-6">
                          <label
                              for="no_hp"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >No Hp</label
                          >
                          <input
                              type="text"
                              id="name"
                              name="no_hp"
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              value="{{ $patient->phone }}"
                              required
                          />
                        </div>
                        <div class="mb-8">
                          <label
                              for="jenis_kelamin"
                              class="block mb-5 text-sm font-medium text-gray-900"
                              >Gender</label
                          >
                          <div class="flex space-x-4">
                              <div class="flex items-center space-x-1">
                                  <input
                                      class="cursor-pointer"
                                      type="radio"
                                      name="jenis_kelamin"
                                      id="gender-male"
                                      value="L"
                                      checked
                                  />
                                  <label for="gender-male"
                                      ><p class="text-sm">Male</p></label
                                  >
                              </div>
                              <div class="flex items-center space-x-1">
                                  <input
                                      class="cursor-pointer"
                                      type="radio"
                                      name="jenis_kelamin"
                                      value="P"
                                      id="gender-female"
                                  />
                                  <label for="gender-female"
                                      ><p class="text-sm">Female</p></label
                                  >
                              </div>
                          </div>
                        </div>
                        <div class="mb-6">
                          <label
                              for="tanggal_lahir"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Tanggal Lahir</label
                          >
                          <input
                              type="date"
                              id="tanggal_lahir"
                              name="tanggal_lahir"
                              value="{{ $patient->birthdate }}"
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              required
                          />
                        </div>
                        <div class="mb-6">
                          <label
                              for="alamat"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Alamat</label
                          >
                          <input
                              type="text"
                              id="alamat"
                              name="alamat"
                              value="{{ $patient->address }}"
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              required
                          />
                        </div>
                      </div>
                    </div>


                    <button id="btn-update" type="submit"
                        class="text-white rounded-full bg-[#ED1C24] font-medium shadow-lg transition duration-200 hover:shadow-[#ED1C24]/50 shadow-[#ED1C24]/30 text-sm w-80 px-6 py-2.5 text-center active:opacity-50 active:translate-y-2 active:shadow-sm">
                        Update
                    </button>
                  </form>
                </div>
                {{-- <div class="flex justify-between mb-6">
                    <a href="admin-data-pasien/create"
                        class="bg-[#ED1C24] text-sm px-4 py-2 font-semibold text-white rounded-full transition duration-150 hover:opacity-70">
                        Tambah Data
                    </a>
                    <div
                        class="flex justify-between px-2 py-1 text-sm border-2 border-gray-300 rounded-md focus:border-gray-600">
                        <input type="text" class="w-56" />
                        <img class="w-5" src="/img/icon-search.svg" alt="">
                    </div>
                </div>
                <table class="border-collapse border-2 w-full border-[#E9E9E9] mt-8">
                    <thead>
                        <tr>
                            <th class="border-2 w-1 text-sm font-semibold py-5 border-[#E9E9E9]">
                                No
                            </th>

                            <th class="border-2 text-sm font-semibold border-[#E9E9E9]">
                                Nama Dokter
                            </th>
                            <th class="border-2 text-sm font-semibold border-[#E9E9E9]">
                                Email
                            </th>
                            <th class="border-2 text-sm font-semibold border-[#E9E9E9]">
                                Alamat
                            </th>
                            <th class="border-2 text-sm font-semibold border-[#E9E9E9]">
                                Poli
                            </th>
                            <th class="border-2 text-sm font-semibold border-[#E9E9E9] w-56">
                                Tempat <br>
                                Tanggal Lahir
                            </th>
                            <th class="border-2 font-semibold border-[#E9E9E9]">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 1; $i <= 6; $i++)
                            <tr class="text-sm">
                                <td class="border-2 border-[#E9E9E9] py-3 px-4">
                                    {{ $i }}
                                </td>
                                <td class="border-2 border-[#E9E9E9] py-3 px-4">
                                    Dr. Jason
                                </td>
                                <td class="border-2 border-[#E9E9E9] py-3 px-4">
                                    jason@employee.telkomuniversity.ac.id
                                </td>
                                <td class="border-2 border-[#E9E9E9] py-3 px-4">
                                    Bandung
                                </td>
                                <td class="border-2 border-[#E9E9E9] py-3 px-4">
                                    Umum
                                </td>
                                <td class="border-2 border-[#E9E9E9] py-3 px-4">
                                    Yogyakarta, 20-01-2003
                                </td>
                                <td class="border-2 border-[#E9E9E9]">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a
                                            class="grid w-8 bg-gray-400 rounded-md place-items-center aspect-square hover:bg-gray-500">
                                            <img src="/img/edit-icon.png" alt="edit-icon" />
                                        </a>
                                        <button
                                            class="grid w-8 bg-red-500 rounded-md place-items-center aspect-square hover:bg-red-600">
                                            <img src="/img/delete-icon.png" alt="delete-icon" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table> --}}
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
             const formUpdate = document.querySelector("#update-form")
    
              formUpdate.addEventListener("submit", (e) => {
              e.preventDefault();
              
              Swal.fire({
              title: 'Warning',
              text: "Are you sure want to update this data?",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#ED1C24',
              cancelButtonColor: '#C5C5C5',
              confirmButtonText: 'Yes'
              }).then((result) => {
                  if (result.isConfirmed) {
                    formUpdate.submit();
                    toggleDisable();
                  } 
              })
              })

          function toggleDisable(){
            const btnUpdate = document.querySelector("#btn-update");
            btnUpdate.setAttribute('disabled', true);
            btnUpdate.style.opacity = 0.6
            btnUpdate.style.pointerEvents = "none"
          }
        </script>

        
@endsection