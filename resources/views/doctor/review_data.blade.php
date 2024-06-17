@extends('layouts.layout_dashboard_doctor')

@section('content')
    <div class="flex flex-col h-full">

        {{-- Header --}}
        <header class="flex items-center justify-between mb-4">
            <div class="flex items-center justify-start space-x-4">
                <h1 class="text-xl font-semibold">Dashboard</h1>
            </div>
            <div class="relative flex items-center space-x-4">
                <button class="relative transition-all duration-100 active:translate-y-1 active:shadow-sm" onclick="toggleDropdown()"> 
                    <div class="flex items-center bg-white p-2 md:space-x-4 md:px-4 shadow-[0px_7px_50px_0px_rgba(0,0,0,0.1)] rounded-xl">
                        <div class="flex items-center justify-center w-8 text-white bg-gray-600 rounded-full aspect-square">
                            <p class="inline-block">{{  Str::ucfirst($user['username'][0]) }}</p>
                        </div>
                        <div class="text-start md:block">
                            <p class="text-xs">{{ $user['name']  }}</p>
                            <p class="text-xs text-[#777A8F]">Dokter</p>
                        </div>
                    </div>
                    </button>
            </div>
        </header>
        
        {{-- Content --}}
        <div class="flex flex-col flex-1 w-full p-6 bg-white rounded-xl">
            {{-- judul, filter rating --}}
            <div class="flex justify-between mb-4">
                <div>
                    <h2 class="text-lg font-semibold">Data Review</h2>
                    <div class="flex space-x-2">
                        <p class="font-medium text-gray-500">Total : {{ $user['rating'] }}</p>
                        <img src="/img/star-icon.png" alt="">
                    </div>
                </div>
                <div class="flex items-start mb-8 space-x-2">
                    <form class="flex space-x-2" action="/dokter/data-review">
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
            {{-- tabel --}}
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
                        @if ($reviews == [])
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center">Tidak ada review</td>
                            </tr>
                        @else
                            @foreach ($reviews as $review)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $user['name'] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ Str::ucfirst($user['specialization']) }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $review['rating'] }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $review['comment'] }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{-- <div class="mt-auto">
                    <div class="w-full mt-10">
                        {{ $reviews->links() }}
                    </div>
                </div> --}}
            </div>  
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/datepicker.min.js"></script>
    <script>
        $(function () {
            $("#datepicker").datepicker();
        });
    </script>
@endsection
