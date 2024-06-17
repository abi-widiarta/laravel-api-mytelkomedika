@extends('layouts.layout_dashboard_admin')

@section('content')
        {{-- @foreach ($schedule as $s)
            <p>{{ $s }}</p>
        @endforeach --}}
        <div class="flex flex-col h-full">
            <header class="flex items-center justify-between mb-4">
                <div class="flex items-center justify-start space-x-4">
                    <img class="w-8" src="/img/antrian-sidebar-icon.png" alt="asd">
                    <h1 class="text-xl font-semibold">Data Review</h1>
                </div>
                <div class="relative flex items-center space-x-4">
                    @include('partials.profile')
                </div>
            </header>

            <div class="flex-1 w-full p-6 bg-white rounded-xl">
                <div class="flex justify-between mb-4">
                    <h2 class="text-lg font-semibold">Kelola Data Review</h2>
                    <div class="flex items-start mb-8 space-x-2">
                        <form class="flex space-x-2" action="/admin/data-review">
                            <div>
                                <select required id="select-jam" name="poli" id="jam" class="block w-full p-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-primary/50">
                                    <option selected disabled>Pilih Poli</option>
                                    <option {{ request('poli') == 'umum' ? 'selected' : ''}} value="umum">Poli Umum</option>
                                    <option {{ request('poli') == 'mata' ? 'selected' : ''}} value="mata">Poli Mata</option>
                                    <option {{ request('poli') == 'gigi' ? 'selected' : ''}} value="gigi">Poli Gigi</option>
                                </select>
                            </div>
                            <div>
                                <select required id="select-jam" name="rating" id="jam" class="block w-full p-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-lg focus:outline-primary/50">
                                    <option selected disabled>Pilih Rating</option>
                                    <option {{ request('rating') == '1' ? 'selected' : ''}} value="1">1</option>
                                    <option {{ request('rating') == '2' ? 'selected' : ''}} value="2">2</option>
                                    <option {{ request('rating') == '3' ? 'selected' : ''}} value="3">3</option>
                                    <option {{ request('rating') == '4' ? 'selected' : ''}} value="4">4</option>
                                    <option {{ request('rating') == '5' ? 'selected' : ''}} value="5">5</option>
                                </select>
                            </div>
                            <button type="submit">Cari</button>
                        </form>
                    </div>
              </div>
                <div class="flex flex-col justify-between flex-1">
                    <table class="w-full text-sm text-left text-gray-500 rtl:text-right">
                        <thead class="text-xs text-gray-700 uppercase border-b">
                            <tr>
                                <th scope="col" class="py-3 pl-5 pr-6">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Dokter
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Poli
                                </th>
                                <th scope="col" class="px-6 py-3 text-center">
                                    Rating
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Comment
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4">
                                      {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $review->doctor->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ Str::ucfirst($review->doctor->specialization) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $review->rating }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $review->comment }}
                                    </td>
                                
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>  
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/datepicker.min.js"></script>
        <script>
          const formDelete = document.querySelectorAll(".doctor-delete-form")

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