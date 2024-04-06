@extends('layouts.layoutDashboardAdmin')

@section('content')
        <div class="flex flex-col h-full">
            <header class="flex items-center justify-between mb-4">
                <div class="flex items-start justify-start space-x-4">
                    <img src="/img/data-pasien-icon.png" alt="asd">
                    <h1 class="text-xl font-semibold">Data Pasien</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div
                        class="py-1 pl-4 pr-2 border-2 space-x-4 border-[#ED1C24] rounded-full flex items-center justify-between">
                        <p class="text-sm font-semibold">Admin John</p>
                        <div class="grid w-8 bg-gray-600 rounded-full place-items-center aspect-square">
                            <p class="m-0 text-white font-base">
                                J
                            </p>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 w-full p-6 bg-white rounded-xl">
              <div class="flex justify-between mb-4">
                  <Link
                      href="/admin-data-pasien"
                      class="flex px-4 py-2 space-x-2 text-sm font-semibold text-white transition duration-150 bg-gray-500 rounded-full hover:opacity-70"
                  >
                      <p>◀</p>
                      <p>Kembali</p>
                  </Link>
              </div>
              <h2 class="mb-10 text-2xl font-semibold text-center text-primary">
                  Tambah Data Pasien
              </h2>
              <div class="flex items-center justify-center flex-1">
                  <form @submit.prevent="submit" class="w-72">
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
                              v-model="form.name"
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              required
                          />
  
                          <!-- <p
                              id="outlined_error_help"
                              class="mt-2 text-xs text-red-600 dark:text-red-400"
                          >
                              asd
                          </p> -->
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
                              v-model="form.email"
                              class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                              required
                          />
                      </div>
  
                      <div class="mb-6">
                          <label
                              for="email"
                              class="block mb-2 text-sm font-medium text-gray-900"
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
                                      v-model="form.gender"
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
                                      v-model="form.gender"
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
                              for="birthdate"
                              class="block mb-2 text-sm font-medium text-gray-900"
                              >Birhdate</label
                          >
                          <input
                              type="date"
                              id="birthdate"
                              name="birthdate"
                              v-model="form.birthdate"
                              class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:border-primary focus:border-1"
                              required
                          />
  
                          <!-- <p
                              id="outlined_error_help"
                              class="mt-2 text-xs text-red-600 dark:text-red-400"
                          >
                              asd
                          </p> -->
                      </div>
  
                      <button
                          type="submit"
                          class="w-full text-white rounded-full bg-primary font-medium shadow-lg transition duration-200 hover:shadow-primary/50 shadow-primary/30 text-sm px-5 py-2.5 text-center"
                      >
                          Submit
                      </button>
                  </form>
              </div>
          </div>
        </div>
@endsection
