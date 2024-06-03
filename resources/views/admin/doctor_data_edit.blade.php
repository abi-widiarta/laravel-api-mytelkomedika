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

            <div class="relative flex-1 w-full p-6 pt-8 bg-white rounded-xl">
              <a class="inline-block px-3 py-2 mb-2 text-white transition-all duration-150 bg-gray-400 rounded-full hover:shadow-md active:translate-y-1" href="/admin/data-dokter">
                <div class="flex space-x-2 text-sm">
                  <p>◀</p>
                  <p>Kembali</p>
                </div>
              </a>
                <h2 class="mb-8 text-lg font-semibold text-center">Edit Data Dokter</h2>
                <div class="flex w-full">
                  <form enctype="multipart/form-data" id="add-form" action="/admin/data-dokter/update?current_username={{ $doctor->username }}" class="flex flex-col items-center w-full bg-gray" method="POST">
                    @csrf
                    <div class="flex space-x-8 w-[80%] mb-4">
                      <div class="w-full">
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
                              value="{{ $doctor->name }}"
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
                              value="{{ $doctor->email }}"
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
                              value="{{ $doctor->username }}"
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              required
                          />
                        </div>
                        <div class="mb-6">
                          <label
                              for="password"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Password</label
                          >
                          <input
                              type="text"
                              id="password"
                              name="password"
                              {{-- value="{{ $doctor->username }}" --}}
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              
                          />
                        </div>
                        <div class="mb-6">
                          <label
                              for="poli"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Poli</label
                          >
                          
                          <select name="poli" id="poli" class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50">
                            <option disabled>Pilih Poli</option>
                            <option {{ $doctor->specialization == "umum" ? 'selected' : ''}} value="umum">Umum</option>
                            <option {{ $doctor->specialization == "mata" ? 'selected' : ''}} value="mata">Mata</option>
                            <option {{ $doctor->specialization == "gigi" ? 'selected' : ''}} value="gigi">Gigi</option>
                          </select>
                        </div>
                        <div class="mb-6">
                          <label
                              for="status"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Status</label
                          >
                          
                          <select name="status" id="status" class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50">
                            <option disabled>Pilih Status</option>
                            <option {{ $doctor->status == "1" ? 'selected' : ''}} value="1">Active</option>
                            <option {{ $doctor->status == "0" ? 'selected' : ''}} value="0">Inactive</option>
                          </select>
                        </div>
                      </div>
  
                      <span class="block w-0.5 bg-gray-300 h-[34rem]"></span>
  
                      <div class="w-full">
                        <div class="mb-6">
                          <label
                              for="no_str"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >No STR</label
                          >
                          <input
                              type="text"
                              id="no_str"
                              name="no_str"
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              value="{{ $doctor->registration_number }}"
                              required
                          />
                        </div>
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
                              value="{{ $doctor->phone }}"
                              required
                          />
                        </div>
                        <div class="mb-8">
                          <div>
                            <label
                                for="jenis_kelamin"
                                class="block mb-5 text-sm font-medium text-gray-900"
                                >Jenis Kelamin</label
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
                              value="{{ $doctor->birthdate }}"
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
                              value="{{ $doctor->address }}"
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              required
                          />
                        </div>
                        <div class="mb-6">
                          <label
                              for="alamat"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Gambar</label
                          >
                          <input name="image" type="file" class="block w-full transition-all duration-300 text-sm text-slate-500 border rounded-lg
                            file:mr-4 file:py-2.5 file:px-4
                            file:border-0
                            file:text-sm file:font-medium
                            file:bg-[#777A8F]/10 file:text-[#777A8F]/60
                            hover:file:bg-[#777A8F]/20 
                          "/>
                        </div>
                      </div>
                    </div>


                    <button id="btn-tambah" type="submit"
                        class="text-white rounded-full bg-[#ED1C24] font-medium shadow-lg transition duration-200 hover:shadow-[#ED1C24]/50 shadow-[#ED1C24]/30 text-sm w-80 px-6 py-2.5 text-center active:opacity-50 active:translate-y-2 active:shadow-sm">
                        Update
                    </button>
                  </form>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
             const formUpdate = document.querySelector("#add-form")
    
              formUpdate.addEventListener("submit", (e) => {
              e.preventDefault();
              
              Swal.fire({
              title: 'Warning',
              text: "Are you sure want to add this data?",
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
            const btnTambah = document.querySelector("#btn-tambah");
            btnTambah.setAttribute('disabled', true);
            btnTambah.style.opacity = 0.6
            btnTambah.style.pointerEvents = "none"
          }
        </script>

        
@endsection