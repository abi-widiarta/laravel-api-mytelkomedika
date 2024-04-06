<!-- Modal toggle -->
<button data-modal-target="static-modal" data-modal-toggle="static-modal" class="py-3 text-sm text-white px-10 shadow-lg bg-gradient-to-r from-[#ED1C24]/90 to-[#ED1C24]/50 rounded-xl transition duration-200 hover:bg-[#ED1C24]">
  Review
</button>

<!-- Main modal -->
<div backdropClasses="bg-gray-200" id="static-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-gray-700/20">
    <div class="relative max-h-full py-4">
        <!-- Modal content -->
        <div class="relative w-full px-10 bg-white rounded-lg shadow">
          <div class="flex items-center justify-center w-full h-full pt-6">
            <div class="mt-2 mb-8 text-center">
                <h3 class="mb-3 text-xl font-semibold leading-6 text-gray-800 capitalize" id="modal-title">Reservasi</h3>
                <span class="block w-full h-[3px] bg-gray-600/10 mb-8 rounded-md"></span>
                <div class="flex space-x-8">
                  <div class="flex flex-col items-center">
                    <img class="object-cover mb-2 rounded-md w-36 h-44" src="{{ $report->reservation->doctor->image }}" alt="">
                    <h2 class="text-base font-semibold">{{ $report->reservation->doctor->name }}</h2>
                    <p>Poli {{  ucfirst($report->reservation->doctor->spesialisasi) }}</p>
                  </div>
                  <div class="h-full w-80">
                    <form class="form-lakukan-reservasi" action="/riwayat-pemeriksaan/detail/review/{{ $report->id }}" method="post">
                      @csrf
                      {{-- <input type="hidden" id="dayName" name="hari">
                      <input type="hidden" id="jam_selesai" name="jam_selesai"> --}}
                      <input type="hidden" name="doctor_id" value="{{ $report->reservation->doctor->id }}">
                      <div class="flex flex-col items-start mb-6 space-y-2">
                        <label class="text-sm font-semibold" for="keluhan">Rating</label>
                        <!-- Rating -->
                        <div class="flex flex-row-reverse items-center justify-end">
                          <input id="hs-ratings-readonly-2" type="radio" class="w-5 h-5 text-transparent bg-transparent border-0 appearance-none cursor-pointer peer -ms-5 checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="rating" value="5">
                          <label for="hs-ratings-readonly-2" class="text-gray-300 pointer-events-none peer-checked:text-yellow-400 active:translate-y-1">
                            <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                              <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                          </label>
                          <input id="hs-ratings-readonly-2" type="radio" class="w-5 h-5 text-transparent bg-transparent border-0 appearance-none cursor-pointer peer -ms-5 checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="rating" value="4">
                          <label for="hs-ratings-readonly-2" class="text-gray-300 pointer-events-none peer-checked:text-yellow-400 active:translate-y-1">
                            <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                              <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                          </label>
                          <input id="hs-ratings-readonly-3" type="radio" class="w-5 h-5 text-transparent bg-transparent border-0 appearance-none cursor-pointer peer -ms-5 checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="rating" value="3">
                          <label for="hs-ratings-readonly-3" class="text-gray-300 pointer-events-none peer-checked:text-yellow-400 active:translate-y-1">
                            <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                              <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                          </label>
                          <input id="hs-ratings-readonly-4" type="radio" class="w-5 h-5 text-transparent bg-transparent border-0 appearance-none cursor-pointer peer -ms-5 checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="rating" value="2">
                          <label for="hs-ratings-readonly-4" class="text-gray-300 pointer-events-none peer-checked:text-yellow-400 active:translate-y-1">
                            <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                              <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                          </label>
                          <input id="hs-ratings-readonly-4" type="radio" class="w-5 h-5 text-transparent bg-transparent border-0 appearance-none cursor-pointer peer -ms-5 checked:bg-none focus:bg-none focus:ring-0 focus:ring-offset-0" name="rating" value="1">
                          <label for="hs-ratings-readonly-4" class="text-gray-300 transition-all duration-150 pointer-events-none peer-checked:text-yellow-400">
                            <svg class="flex-shrink-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                              <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                            </svg>
                          </label>
                        </div>
                        <!-- End Rating -->
                      </div>
                      <div class="flex flex-col items-start mb-6 space-y-2">
                        <label class="text-sm font-semibold" for="keluhan">Review</label>
                        <textarea name="comment" autocomplete="off" class="resize-none w-full px-2 py-2 border border-gray-300 bg-white text-gray-900 text-sm rounded-md block p-1 focus:outline-[#ED1C24]/50 mr-3" name="keluhan" id="keluhan" rows="5"></textarea>
                      </div>

                      <div class="space-x-4 sm:flex sm:items-center">
                        <button
                            type="button"
                            data-modal-hide="static-modal"
                            class="cursor-pointer border rounded-lg text-gray-900 bg-white font-medium hover:shadow-xl shadow-lg transition duration-200 text-sm w-full sm:w-auto px-6 py-2.5 text-center active:opacity-50 active:translate-y-2 active:shadow-sm">
                            Batalkan
                        </button>

                        <button type="submit"
                            class="text-white rounded-lg bg-[#ED1C24] font-medium shadow-lg transition duration-200 hover:shadow-[#ED1C24]/50 shadow-[#ED1C24]/30 text-sm w-full sm:w-auto px-6 py-2.5 text-center active:opacity-50 active:translate-y-2 active:shadow-sm">
                            Kirim
                        </button>
                      </div>
                    </form>
                  </div>
                </div>
            </div>
          </div>
        </div>
    </div>
  
</div>

<script>
  console.log("tes")
  // Mendapatkan elemen-elemen input radio
  const radioInputs = document.querySelectorAll('input[name="rating"]');

  // Menambahkan event listener untuk setiap elemen input radio
  radioInputs.forEach(input => {
      input.addEventListener('change', function() {
          // Mendapatkan nilai rating yang dipilih
          const selectedRating = this.value;

          // Menampilkan nilai rating pada konsol
          console.log('Selected Rating:', selectedRating);
      });
  });
</script>

{{-- <script defer>
  let dokterHariPraktek = <?= json_encode($doctor->schedule_time) ?>;
  let maxSelectableDate = new Date("<?= $doctor->schedule_time[0]->pivot->tanggal_berlaku_sampai ?>");


  // Cek hasilnya di konsol
  console.log(maxSelectableDate);
  
  const selectJam = document.querySelector('#select-jam')
  // Objek yang memetakan nama hari ke indeks (Minggu = 0, Senin = 1, ..., Sabtu = 6)
  var dayIndexMap = {
      'minggu': 0,
      'senin': 1,
      'selasa': 2,
      'rabu': 3,
      'kamis': 4,
      'jumat': 5,
      'sabtu': 6
  };

  // Extracting the 'hari' properties from each object and converting to lowercase
  var hariArray = dokterHariPraktek.map(schedule => dayIndexMap[schedule.pivot.hari.toLowerCase()]);
  // console.log(hariArray)

  $(function() {
    $("#datepicker").datepicker({
      beforeShowDay: function(date) {
        var dayIndex = date.getDay();

        var isSelectable = hariArray.indexOf(dayIndex) != -1;
        console.log(isSelectable)
        
        isSelectable = isSelectable && date >= new Date(new Date().setHours(0, 0, 0, 0)) && date <= maxSelectableDate;

        return [isSelectable, isSelectable ? "ui-state-selectable" : "ui-state-disabled"];
      },

      onSelect: function(dateText, inst) {
        // Callback ini akan dipanggil ketika suatu tanggal dipilih
        var selectedDate = new Date(dateText);
        var dayName = selectedDate.toLocaleDateString('id-ID', { weekday: 'long' });
        
        selectJam.innerHTML = `
          <option disabled selected>Pilih Jam</option>
        `

        console.log("Tanggal yang dipilih:", selectedDate);

        dokterHariPraktek.forEach(element => {
          console.log("element" + element)
          if(element.pivot.hari ==  dayName.toLowerCase()) {
            console.log(element.jam_mulai)
            selectJam.innerHTML += 
            `
              <option value="${ element.jam_mulai} - ${ element.jam_selesai}">${element.jam_mulai.substring(0, 5)} - ${element.jam_selesai.substring(0, 5)}</option>
            `
          }
        });
      },
    });
  });


</script> --}}