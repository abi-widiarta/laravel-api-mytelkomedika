@extends('layouts.layoutDashboard')

@section('content')
        <div class="flex flex-col h-full">
            <header class="flex items-center justify-between mb-4">
                <div class="flex items-start justify-start space-x-4">
                    <img src="/img/profile-icon.png" alt="asd">
                    <h1 class="text-xl font-semibold">Profile</h1>
                </div>
                <div class="relative flex items-center space-x-4">
                    @include('partials.dropdownProfile')
                </div>
            </header>

            <div class="relative flex-1 w-full p-6 bg-white rounded-xl">
                <h2 class="absolute text-lg font-semibold">Edit Profile</h2>
                <div class="flex flex-col items-center w-full mt-2 mb-7">
                  <div class="flex items-center justify-center mb-2 rounded-full shadow-md w-14 aspect-square bg-slate-400">
                    <h1 class="text-4xl text-white">{{ Auth::user()->name[0] }}</h1>
                  </div>
                  <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                  <p class="text-xs">Student</p>
                </div>
                <div class="flex w-full">
                  <form id="update-form" class="flex flex-col items-center w-full bg-gray" method="POST" action="/profile/edit/{{ Auth::user()->id }}">
                    @csrf
                    <div class="flex space-x-8 w-[80%] mb-4">
                      <div class="w-full">
                        <div class="mb-6">
                          <label
                              for="student_id"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Nim</label
                          >
                          <input
                              type="text"
                              id="student_id"
                              name="student_id"
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              value="{{ Auth::user()->student_id }}"
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
                              value="{{ Auth::user()->name }}"
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
                              value="{{ Auth::user()->username }}"
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
                              value="{{ Auth::user()->email }}"
                              disabled
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              required
                          />
                        </div>
                      </div>
  
                      <span class="block w-0.5 bg-gray-300 h-[22rem]"></span>
  
                      <div class="w-full">
                        <div class="mb-6">
                          <label
                              for="phone"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >No Hp</label
                          >
                          <input
                              type="text"
                              id="name"
                              name="phone"
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              value="{{ Auth::user()->phone }}"
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
                                      name="gender"
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
                                      name="gender"
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
                              id="birthdate"
                              name="birthdate"
                              value="{{ Auth::user()->birthdate }}"
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              required
                          />
                        </div>
                        <div class="mb-6">
                          <label
                              for="address"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Alamat</label
                          >
                          <input
                              type="text"
                              id="address"
                              name="address"
                              value="{{ Auth::user()->address }}"
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