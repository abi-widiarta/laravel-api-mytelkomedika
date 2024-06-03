@extends('layouts.layoutDashboardAdmin')

@section('content')

        <div class="flex flex-col h-full">
            <header class="flex items-center justify-between mb-4">
                <div class="flex items-center justify-start space-x-4">
                    <img class="w-8" src="/img/antrian-sidebar-icon.png" alt="asd">
                    <h1 class="text-xl font-semibold">Antrian Pemeriksaan</h1>
                </div>
                <div class="relative flex items-center space-x-4">
                    @include('partials.dropdownProfile')
                </div>
            </header>

            <div class="flex-1 w-full px-6 pt-6 pb-24 bg-white rounded-xl">
                <div class="flex justify-between mb-4">
                    <h2 class="text-lg font-semibold">Kelola Hasil Pemeriksaan</h2>
                </div>
                <div class="flex mb-8 space-x-2 text-sm">
                    <ul>
                        <li>Tanggal</li>
                        <li>Dokter Bertugas</li>
                        <li>Poli</li>
                    </ul>
                    <ul>
                        <li>:</li>
                        <li>:</li>
                        <li>:</li>
                    </ul>
                    <ul>
                        <li>12-12-2023</li>
                        @isset($report->reservation->doctor->name)
                            <li>{{ $report->reservation->doctor->name }}</li>
                        @endisset
                        @isset($report->reservation->doctor->specialization)
                            <li>{{ Str::ucfirst($report->reservation->doctor->specialization) }}</li>
                        @endisset
                    </ul>
                </div>  
                <div class="w-full">
                  <h1 class="mb-10 text-lg font-semibold text-center">Form Hasil Pemeriksaan</h1>
                  <form class="w-[80%] mx-auto pl-6 space-y-8" action="/admin/antrian-pemeriksaan/hasil-pemeriksaan/update?id={{ $report->reservation->id }}" method="post">
                    @csrf
                    <div class="flex items-center">
                      <label class="w-[20%] text-sm" for="patient">Pasien</label>
                      <input name="name" disabled value="{{ $report->reservation->patient->name }}" class="w-[70%] bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 focus:outline-primary/50"  id="patient" type="text">
                    </div>
                    <div class="flex items-center">
                      <label class="w-[20%] text-sm" for="berat_badan">Berat Badan (Kg)</label>
                      <input required value="{{ $report->weight }}" name="berat_badan" class="w-[70%] bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 focus:outline-primary/50"  id="berat_badan" type="text">
                    </div>
                    <div class="flex items-center">
                      <label class="w-[20%] text-sm" for="tinggi_badan">Tinggi Badan (cm)</label>
                      <input required value="{{ $report->height }}" name="tinggi_badan" class="w-[70%] bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 focus:outline-primary/50"  id="tinggi_badan" type="text">
                    </div>
                    <div class="flex items-center">
                      <label class="w-[20%] text-sm" for="suhu_badan">Suhu Badan (C)</label>
                      <input required value="{{ $report->temperature }}" name="suhu_badan" class="w-[70%] bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 focus:outline-primary/50"  id="suhu_tubuh" type="text">
                    </div>
                    <div class="flex items-center">
                      <label class="w-[20%] text-sm" for="keluhan">Keluhan</label>
                      <input required type="text" value="{{ $report->initial_complaint }}" name="keluhan" class="w-[70%] resize-none bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 focus:outline-primary/50" name="keluhan" id="keluhan">
                    </div>
                    <div class="flex items-center">
                      <label class="w-[20%] text-sm" for="diagnosa">Diagnosa</label>
                      <input required type="text" value="{{ $report->diagnosis }}" name="diagnosa" class="w-[70%] resize-none bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 focus:outline-primary/50" name="diagnosa" id="keluhan">
                    </div>
                    <div class="flex items-center">
                      <label class="w-[20%] text-sm" for="anjuran">Anjuran</label>
                      <input required type="text" value="{{ $report->recommendations }}" name="anjuran" class="w-[70%] resize-none bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 focus:outline-primary/50" name="anjuran" id="keluhan"></input>
                    </div>
                    <div class="flex items-center">
                      <label class="w-[20%] text-sm" for="anjuran">Daftar Obat</label>
                      <textarea required rows="3" name="obat" class="w-[70%] resize-none bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 focus:outline-primary/50" name="anjuran" id="keluhan">{{ $report->medications }}</textarea>
                    </div>
                    <div class="flex items-center">
                        <label class="w-[20%] text-sm" for="diagnosa">Biaya</label>
                        <input value="{{ $report->reservation->payment->amount }}" type="text" name="biaya" class="w-[70%] resize-none bg-white disabled:bg-slate-100 disabled:text-gray-500 border border-gray-300 text-gray-900 text-sm rounded-lg block p-2.5 focus:outline-primary/50" id="biaya">
                      </div>
                    <div class="flex items-center">
                      <label class="w-[20%] text-sm" for="anjuran">Surat Dokter</label>
                      {{-- <input name="surat_dokter" type="checkbox"> --}}
                      <input {{ $report->sick_note == '1' ? 'checked' : '' }} type="checkbox" name="surat_dokter" value="1">
                    </div>
                    <button id="btn-tambah" type="submit"
                        class="text-white block mx-auto rounded-full bg-[#ED1C24] font-medium shadow-lg transition duration-200 hover:shadow-[#ED1C24]/50 shadow-[#ED1C24]/30 text-sm w-80 px-6 py-2.5 text-center active:opacity-50 active:translate-y-2 active:shadow-sm">
                        Update
                    </button>
                  </form>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/datepicker.min.js"></script>
        <script>
            // Mendapatkan tanggal saat ini
            let today = new Date();
            let dd = String(today.getDate()).padStart(2, '0');
            let mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
            let yyyy = today.getFullYear();

            today = mm + '/' + dd + '/' + yyyy;

            // Menetapkan tanggal saat ini sebagai placeholder
            document.getElementById('datepicker').setAttribute('value', today);


            $(function () {
                $("#datepicker").datepicker({
                    minDate: 0, // Hanya hari ini atau setelahnya
                    // onSelect: function (dateText, inst) {
                    //     // Tanggal awal
                    // var originalDate = $("#datepicker").val();

                    // // Buat objek Date dari string tanggal
                    // var dateObject = new Date(originalDate);

                    // // Ambil tahun, bulan, dan tanggal
                    // var year = dateObject.getFullYear();
                    // var month = ('0' + (dateObject.getMonth() + 1)).slice(-2); // Tambah 1 karena bulan dimulai dari 0
                    // var day = ('0' + dateObject.getDate()).slice(-2);

                    // // Format ulang tanggal
                    // var formattedDate = year + '-' + month + '-' + day;

                    // // Hasilnya adalah "2023-12-18"
                    // console.log(formattedDate);
                                                
                    //     // Lakukan pengalihan halaman dengan menggunakan window.location
                    //     // Gantilah URL sesuai kebutuhan Anda
                    //     window.location.href = '/admin/antrian-pemeriksaan?tanggal=' + formattedDate;
                    // }
                });
            });
        </script>
@endsection