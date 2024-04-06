@extends('layouts.layoutdashboard')

@section('content')
        <div class="flex flex-col h-full">
            <header class="flex items-center justify-between mb-4">
                <div class="flex items-center justify-start space-x-4">
                    <img class="w-8" src="/img/antrian-sidebar-icon.png" alt="asd">
                    <h1 class="text-xl font-semibold">Lakukan Reservasi</h1>
                </div>
                <div class="relative flex items-center space-x-4">
                    @include('partials.dropdownProfile')
                </div>
            </header>
            
            <div class="mb-4">
                <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown-category" class="flex justify-between text-[#777A8F] focus:outline-[#777A8F] w-40 after:hidden bg-white border border-white/40 hover:bg-white/20 font-medium rounded-xl text-xs px-5 py-2.5 text-start items-center shadow-[0px_7px_61px_0px_rgba(198,203,232,0.5)] md:text-sm md:w-48" type="button">{{ request('poli') ? Str::ucfirst(request('poli')) : 'All'}}<svg class="w-2.5 h-2.5 ml-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg></button>
                <!-- Dropdown menu -->
                <div id="dropdown-category" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-[0px_7px_61px_0px_rgba(198,203,232,0.5)] w-40 -translate-y-20 md:mt-0 md:w-44">
                    <ul class="py-2 text-xs text-[#777A8F] md:text-sm" aria-labelledby="dropdownDefaultButton">
                    <li>
                        <a href="/lakukan-reservasi" class="block px-4 py-2 hover:bg-[#777A8F]/10">All</a>
                    </li>
                    <li>
                        <a href="/lakukan-reservasi/?poli=umum" class="block px-4 py-2 hover:bg-[#777A8F]/10">Poli Umum</a>
                    </li>
                    <li>
                        <a href="/lakukan-reservasi/?poli=mata" class="block px-4 py-2 hover:bg-[#777A8F]/10">Poli Mata</a>
                    </li>
                    <li>
                        <a href="/lakukan-reservasi/?poli=gigi" class="block px-4 py-2 hover:bg-[#777A8F]/10">Poli Gigi</a>
                    </li>
                    {{-- @foreach ($categories as $category)
                        
                    @endforeach --}}
                    
                    </ul>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6">
                
                @foreach ($doctors as $doctor)
                    <div onclick="location.href='/lakukan-reservasi/detail/{{ $doctor->username }}';" class="flex justify-start py-6 pl-6 pr-10 space-x-4 transition-all duration-150 bg-white shadow-lg hover:cursor-pointer hover:pointer hover:-translate-y-1 rounded-xl shadow-gray-100">
                        <div class="space-y-2 text-center">
                            <img class="object-cover h-56 rounded-lg w-44" src="{{ $doctor->image}}" alt="doctor-1" />
                        </div>
                        <span class="block w-[2px] bg-gray-200"></span>

                        <div class="flex flex-col justify-start flex-1">
                            <h1 class="mb-2 text-lg font-semibold">{{ $doctor->name }}</h1>
                            <div class="flex flex-col mb-4 space-y-2">
                                <div class="flex items-center space-x-2">
                                    <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#DCFCE7]">
                                        <img src="/img/poli-green.png" alt="">
                                    </div>
                                    <p class="text-sm font-medium text-gray-500">Poli {{ Str::ucfirst($doctor->specialization) }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#DCFCE7]">
                                        <img src="/img/patient-green.png" alt="">
                                    </div>
                                    @if ($doctor->patient_total == 0)
                                        <p class="text-sm font-medium text-gray-500">Baru ✨</p>
                                    @else
                                        <p class="text-sm font-medium text-gray-500">{{ $doctor->patient_total }} patients</p>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="flex justify-center items-center w-7 rounded-full aspect-square bg-[#DCFCE7]">
                                        <img src="/img/review-green.png" alt="">
                                    </div>
                                    @if ($doctor->review_total == 0)
                                        <p class="text-sm font-medium text-gray-500">Baru ✨</p>
                                    @else
                                        <p class="text-sm font-medium text-gray-500">{{ $doctor->review_total }} review</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center mb-4 space-x-1">
                                @if ( $doctor->rating == 0)
                                    <p class="text-sm font-semibold">Rating : <span class="font-normal">Baru ✨</span></p>
                                @else
                                    <p class="text-sm font-semibold">Rating : {{ $doctor->rating }}</p>
                                    <img src="/img/star-icon.png" alt="">
                                @endif
                            </div>
                            <div class="flex justify-start w-full ">
                                <a href="/lakukan-reservasi/detail/{{ $doctor->username }}" class="py-2.5 text-sm text-white px-12 shadow-lg bg-gradient-to-r from-[#ED1C24]/90 to-[#ED1C24]/50 rounded-lg transition duration-200 hover:bg-[#ED1C24]">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="w-full mt-10">
                {{ $doctors->links() }}
            </div>
        </div>

        <script defer>
            let modal = document.querySelectorAll(".modal-reservasi")
            let modalContainer = document.querySelectorAll(".modal-reservasi-container")

            let arrModal = Array.from( modal )
            let arrModalContainer = Array.from( modalContainer )

            arrModal.forEach(el => {
                setTimeout(() => {
                  el.classList.remove("hidden")
                }, 250);
            });

            arrModalContainer.forEach(el => {
                setTimeout(() => {
                  el.style.backgroundColor = "rgba(0,0,0,0.2)"
                }, 250);
            });
            
          
            function reverseBgColor() {
              console.log("reverse")
              // modalContainer.style.backgroundColor = "rgba(0,0,0,0)"
            };

            function setData(data) {
                console.log(data)
            }
          
             // Daftar hari yang dapat dipilih (contoh: Senin dan Rabu)
            var dokterHariPraktek = [1, 3]; // 0 = Minggu, 1 = Senin, ..., 6 = Sabtu
          
          $(function() {
            $("#datepicker").datepicker({
              beforeShowDay: function(date) {
                // Mendapatkan indeks hari (0 = Minggu, 1 = Senin, ..., 6 = Sabtu)
                var dayIndex = date.getDay();
          
                // Mengecek apakah hari ini dapat dipilih
                var isSelectable = dokterHariPraktek.indexOf(dayIndex) != -1;
          
                // Mengecek apakah tanggal berada dalam satu bulan ke depan
                var isWithinOneMonth = date >= new Date() && date <= new Date(new Date().setMonth(new Date().getMonth() + 1));
          
                return [isSelectable && isWithinOneMonth, isSelectable ? "ui-state-selectable" : "ui-state-disabled"];
              }
            });
          });

          
          </script>
@endsection
