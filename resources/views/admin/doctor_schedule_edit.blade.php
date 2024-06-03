@extends('layouts.layoutDashboardAdmin')

@section('content')
        <div class="flex flex-col h-full">
            <header class="flex items-center justify-between mb-4">
                <div class="flex items-start justify-start space-x-4">
                  <img src="/img/data-pasien-icon.png" alt="asd">
                  <h1 class="text-xl font-semibold">Jadwal Dokter</h1>
                </div>
                <div class="relative flex items-center space-x-4">
                    @include('partials.dropdownProfile')
                </div>
            </header>

            <div class="relative flex-1 w-full p-6 pt-8 pb-8 bg-white rounded-xl">
              <a class="inline-block px-3 py-2 mb-2 text-white transition-all duration-150 bg-gray-400 rounded-full hover:shadow-md active:translate-y-1" href="/admin/jadwal-dokter">
                <div class="flex space-x-2 text-sm">
                  <p>◀</p>
                  <p>Kembali</p>
                </div>
              </a>
                <div class="flex flex-col w-full space-y-10">
                  <div>
                    <h2 class="mb-8 text-lg font-semibold text-center">Edit Jadwal Dokter</h2>
                    <div class="flex w-full">
                      <form enctype="multipart/form-data" id="add-form" action="/admin/jadwal-dokter/update?id={{ $schedule->id }}&dokter={{ $schedule->doctor->id }}" class="flex flex-col items-center w-full bg-gray" method="POST">
                        @csrf
                        <div class="flex space-x-8 w-[37%] mb-4">
                          <div class="w-full">
                            <div class="mb-6">
                              <label
                                  for="dokter"
                                  class="block mb-2 text-sm font-medium text-gray-900"
                                  >Dokter</label
                              >
                              
                              <input
                                type="text"
                                id="dokter"
                                name="dokter"
                                value="{{ $schedule->doctor->name }}"
                                disabled
                                class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                                required
                              />
                            </div>
                            <div class="mb-6">
                              <label
                                  for="hari"
                                  class="block mb-2 text-sm font-medium text-gray-900"
                                  >Hari</label
                              >
                              <select name="hari" id="hari" class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50">
                                <option disabled>Pilih Hari</option>
                                <option {{ $schedule->day == 'senin' ? 'selected' : '' }} value="senin">Senin</option>
                                <option {{ $schedule->day == 'selasa' ? 'selected' : '' }} value="selasa">Selasa</option>
                                <option {{ $schedule->day == 'rabu' ? 'selected' : '' }} value="rabu">Rabu</option>
                                <option {{ $schedule->day == 'kamis' ? 'selected' : '' }} value="kamis">Kamis</option>
                                <option {{ $schedule->day == 'jumat' ? 'selected' : '' }} value="jumat">Jumat</option>
                                <option {{ $schedule->day == 'sabtu' ? 'selected' : '' }} value="sabtu">Sabtu</option>
                                <option {{ $schedule->day == 'minggu' ? 'selected' : '' }} value="minggu">Minggu</option>
                              </select>
                            </div>
                            <div class="mb-6">
                              <label
                                  for="jam"
                                  class="block mb-2 text-sm font-medium text-gray-900"
                                  >Jam</label
                              >
                              <select required id="jam" name="schedule_time_id" id="jam" class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50">
                                <option disabled>Pilih Jam</option>
                                @foreach ($schedule_time as $time)
                                    <option {{ $time->id == $schedule->schedule_time_id ? 'selected' : ''}} value="{{ $time->id }}">{{ \Carbon\Carbon::parse($time->start_hour)->format('H:i') }} - {{ \Carbon\Carbon::parse($time->end_hour)->format('H:i') }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="mb-6">
                              <label
                                  for="tanggal_berlaku_sampai"
                                  class="block mb-2 text-sm font-medium text-gray-900"
                                  >Tanggal Berlaku Sampai</label
                              >
                              <input
                                  type="date"
                                  id="tanggal_berlaku_sampai"
                                  name="tanggal_berlaku_sampai"
                                  value="{{ $schedule->end_date }}"
                                  class="bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:outline-primary/50"
                                  required
                              />
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
  
                  <div class="pr-4 text-sm w-[80%] mx-auto">
                    <h3 class="mt-10 mb-4 text-lg font-semibold text-center">Jadwal Terisi</h3>
                    <div class="flex">
                      <div class="w-[20%]">
                        <div class="">
                          <h2 class="invisible mb-1 font-semibold">Poli</h2>
                          <div>
                            <h1 class="invisible mb-2">Hari</h1>
                            <div class="text-justify">
                              <p class="pl-2 mb-2">07:00 - 09:00</p>
                              <p class="pl-2 mb-2">10:00 - 12:00</p>
                              <p class="pl-2 mb-2">13:00 - 15:00</p>
                              <p class="pl-2 mb-2">16:00 - 18:00</p>
                              <p class="pl-2 mb-2">19:00 - 21:00</p>
                            </div>
                          </div>
                        </div>
                        <div class="">
                          <h2 class="invisible mb-1 font-semibold">Poli</h2>
                          <div>
                            <h1 class="invisible mb-7">Hari</h1>
                            <div class="text-justify">
                              <p class="pl-2 mb-2">07:00 - 09:00</p>
                              <p class="pl-2 mb-2">10:00 - 12:00</p>
                              <p class="pl-2 mb-2">13:00 - 15:00</p>
                              <p class="pl-2 mb-2">16:00 - 18:00</p>
                              <p class="pl-2 mb-2">19:00 - 21:00</p>
                            </div>
                          </div>
                        </div>
                        <div class="">
                          <h2 class="invisible mb-1 font-semibold">Poli</h2>
                          <div>
                            <h1 class="invisible mb-7">Hari</h1>
                            <div class="text-justify">
                              <p class="pl-2 mb-2">07:00 - 09:00</p>
                              <p class="pl-2 mb-2">10:00 - 12:00</p>
                              <p class="pl-2 mb-2">13:00 - 15:00</p>
                              <p class="pl-2 mb-2">16:00 - 18:00</p>
                              <p class="pl-2 mb-2">19:00 - 21:00</p>
                            </div>
                          </div>
                          
                        </div>
                 
                      </div>
                      <div class="w-[80%]">
                        @foreach ($schedule_status as $category => $days)
                          <div class="mb-4">
                            <h2 class="font-semibold">Poli {{ ucfirst($category) }}</h2>
                            <div class="grid grid-cols-7">
                                @foreach ($days as $day => $slots)
                                  <div>
                                    <h1 class="mb-2 font-medium text-gray-600">{{ Str::ucfirst($day) }}</h1>
                                    <div class="mb-4">
                                      @foreach ($slots as $slot)
                                        @if ($slot != '-')
                                            <p class="pl-2 mb-2">Isi</p>
                                        @else
                                          <p class="pl-2 mb-2">{{ $slot }}</p>
                                        @endif
                                      @endforeach
                                    </div>
                                  </div>
                                @endforeach  
                            </div>  
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
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
            const btnTambah = document.querySelector("#btn-tambah");
            btnTambah.setAttribute('disabled', true);
            btnTambah.style.opacity = 0.6
            btnTambah.style.pointerEvents = "none"
          }
        </script>

        
@endsection