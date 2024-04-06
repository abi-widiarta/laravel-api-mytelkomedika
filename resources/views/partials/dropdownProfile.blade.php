<button class="relative transition-all duration-100 active:translate-y-1 active:shadow-sm" onclick="toggleDropdown()"> 
  <div class="flex items-center bg-white p-2 md:space-x-4 md:px-4 shadow-[0px_7px_50px_0px_rgba(0,0,0,0.1)] rounded-xl">
      <div class="flex items-center justify-center w-8 text-white bg-gray-600 rounded-full aspect-square">
          <p class="inline-block">{{ Auth::user()->username[0] }}</p>
      </div>
      <div class="text-start md:block">
          <p class="text-xs">{{ Auth::user()->name ?? Auth::guard('admin')->user()->username  }}</p>
          <p class="text-xs text-[#777A8F]">{{ Auth::guard('web')->check() ? 'Student' : 'Admin' }}</p>
      </div>
  </div>
</button>
<div id="dropdown-menu" class="absolute pointer-events-none opacity-0 top-11 right-0 w-40 rent-request-form-logout z-10 border bg-white divide-y divide-gray-100 rounded-lg shadow-[0px_7px_61px_0px_rgba(198,203,232,0.5)] transition-all duration-300 md:mt-0">
  <a href="/profile" class="flex justify-start w-full items-end space-x-2 text-sm font-normal text-[#777A8F] hover:bg-gray-400/10 transition-all duration-150 px-4 py-3 rounded-xl">
      <svg class="w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M7 8C7 5.23858 9.23858 3 12 3C14.7614 3 17 5.23858 17 8C17 10.7614 14.7614 13 12 13C9.23858 13 7 10.7614 7 8ZM12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11Z" fill="currentColor"></path>
          <path d="M6.34315 16.3431C4.84285 17.8434 4 19.8783 4 22H6C6 20.4087 6.63214 18.8826 7.75736 17.7574C8.88258 16.6321 10.4087 16 12 16C13.5913 16 15.1174 16.6321 16.2426 17.7574C17.3679 18.8826 18 20.4087 18 22H20C20 19.8783 19.1571 17.8434 17.6569 16.3431C16.1566 14.8429 14.1217 14 12 14C9.87827 14 7.84344 14.8429 6.34315 16.3431Z" fill="currentColor"></path>
      </svg>
      <p >Profile</p>
  </a>
</div>


<script>
  // Fungsi untuk menutup dropdown jika di-klik di luar dropdown
  function closeDropdownOnClickOutside(event) {
      const dropdownMenu = document.querySelector("#dropdown-menu");
      
      // Periksa apakah elemen yang diklik berada di dalam dropdown
      const isClickInsideDropdown = dropdownMenu.contains(event.target);
  
      // Jika tidak, tutup dropdown
      if (!isClickInsideDropdown) {
          dropdownMenu.classList.remove("dropdown-open");
          // Hapus event listener setelah dropdown ditutup
          document.removeEventListener("click", closeDropdownOnClickOutside);
      }
  }
  
  // Fungsi toggle untuk membuka dan menutup dropdown
  function toggleDropdown() {
      const dropdownMenu = document.querySelector("#dropdown-menu");
      
      // Periksa apakah dropdown sedang terbuka atau tertutup
      const isOpen = dropdownMenu.classList.contains("dropdown-open");
  
      // Jika terbuka, tutup; jika tertutup, buka
      if (isOpen) {
          dropdownMenu.classList.remove("dropdown-open");
      } else {
          dropdownMenu.classList.add("dropdown-open");
          // Tambahkan event listener untuk menutup dropdown jika diklik di luar dropdown
          setTimeout(() => {
              document.addEventListener("click", closeDropdownOnClickOutside);
          }, 300);
      }
  }
  </script>