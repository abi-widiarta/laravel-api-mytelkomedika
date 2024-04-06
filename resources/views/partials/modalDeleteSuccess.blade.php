<div x-data="{ isOpen: true }" class="relative flex">

  {{-- <button @click="isOpen = true"  class="grid w-8 bg-red-500 rounded-md place-items-center aspect-square hover:bg-red-600">
      <img src="/img/delete-icon.png" alt="delete-icon" />
  </button> --}}


  <div x-show="isOpen" 
      x-transition:enter="transition duration-100 ease-out"
      x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0"
      x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
      x-transition:leave="transition duration-100 ease-in"
      x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
      x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0"
      class="fixed inset-0 z-10 overflow-y-auto" 
      aria-labelledby="modal-title" role="dialog" aria-modal="true"
  >
      <div id="modal-delete-success-container" class="items-end justify-center hidden min-h-screen px-4 pt-4 pb-20 text-center transition-all duration-500 sm:block sm:p-0">
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

          <div id="modal-delete-success-container" class="relative hidden inline-block px-10 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl modal-reservasi sm:my-8 sm:align-middle">
              <div class="flex flex-col items-center justify-center w-full h-full ">
                  <div class="mt-2 mb-4 text-center">
                      <h3 class="text-[#ED1C24] mb-3 text-xl font-semibold leading-6" id="modal-title">SUCCESS</h3>
                      <p class="mb-6">Data has been deleted successfully</p>
                      <a
                          @click="isOpen = false"
                          class="cursor-pointer text-white rounded-lg bg-[#ED1C24] font-medium shadow-lg transition duration-200 hover:shadow-[#ED1C24]/50 shadow-[#ED1C24]/30 text-sm w-full sm:w-auto px-6 py-2.5 text-center active:opacity-50 active:translate-y-2 active:shadow-sm">
                          OK
                      </a>
                    
                  </div>

                  
              </div>
          </div>
      </div>
  </div>
</div>
@endsection

{{-- <script defer>
  let modalDeleteSuccess = document.querySelector("#modal-delete-success")
  let modalContainerDeleteSuccess = document.querySelector("#modal-delete-success-container")
  setTimeout(() => {
    modalDeleteSuccess.classList.remove("hidden")
  }, 250);

  setTimeout(() => {
    modalContainerDeleteSuccess.style.backgroundColor = "rgba(0,0,0,0.2)"
  }, 250);

  function reverseBgColor() {
    console.log("reverse")
    // modalContainer.style.backgroundColor = "rgba(0,0,0,0)"
  };
</script> --}}