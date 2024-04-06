@extends('layouts.layoutDashboardAdmin')

@section('content')
        <div class="flex flex-col h-full">
            <header class="flex items-center justify-between mb-4">
                <div class="flex items-start justify-start space-x-4">
                  <img src="/img/data-pasien-icon.png" alt="asd">
                  <h1 class="text-xl font-semibold">Data Admin</h1>
                </div>
                <div class="relative flex items-center space-x-4">
                    @include('partials.dropdownProfile')
                </div>
            </header>

            <div class="relative flex-1 w-full p-6 pt-8 bg-white rounded-xl">
              <a class="inline-block px-3 py-2 mb-6 text-white transition-all duration-150 bg-gray-400 rounded-full hover:shadow-md active:translate-y-1" href="/admin/data-dokter">
                <div class="flex space-x-2 text-sm">
                  <p>◀</p>
                  <p>Kembali</p>
                </div>
              </a>
              <h2 class="mb-6 text-lg font-semibold text-center">Tambah Data Admin</h2>
              <div class="flex w-full">
                <form id="add-form" action="/admin/data-admin/store" class="flex flex-col items-center w-full bg-gray" method="POST">
                  @csrf
                  <div class="flex flex-col items-center space-x-8 w-[40%] mb-4">
                    <div class="w-full">
                      <div class="mb-6">
                        <label
                            for="name"
                            class="block mb-2 text-sm font-medium text-gray-900"
                            >Name</label
                        >
                        <input
                            type="text"
                            id="name"
                            name="name"
                            {{-- value="{{ $patient->username }}" --}}
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
                            {{-- value="{{ $patient->username }}" --}}
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
                            {{-- value="{{ $patient->email }}" --}}
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
                            {{-- value="{{ $patient->username }}" --}}
                            class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                            required
                        />
                      </div>
                    </div>
                    <button id="btn-tambah" type="submit" class="text-white rounded-full bg-[#ED1C24] font-medium shadow-lg transition duration-200 hover:shadow-[#ED1C24]/50 shadow-[#ED1C24]/30 text-sm w-80 px-6 py-2.5 text-center active:opacity-50 active:translate-y-2 active:shadow-sm mt-4">
                        Tambah
                    </button>
                  </div>
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
              text: "Anda yakin akan menambahkan data ini?",
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