<!-- component -->

<section class="bg-blueGray-50">
{{-- <div class="w-full xl:w-full mb-12 xl:mb-0 px-1 mx-auto mt-4"> --}}
  <div class="relative flex flex-col min-w-0 break-words bg-white w-full shadow-lg rounded ">
    {{-- <div class="w-full rounded-t mb-0 px-4 py-3 border-0">
      <div class="flex justify-between items-center w-full">
        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
            <h1 class="font-semibold">{{$dept->department_name}}</h1>
        </div>
      </div> --}}
    </div>

    <div class="block w-full m-4 overflow-x-auto">

        {{-- <p>
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Similique commodi eligendi porro sint corporis. Quod dolore fugiat asperiores laborum facilis. Eius voluptates sequi iure cumque ex nam atque molestias maiores.
        </p> --}}
        @livewire('department-users', ['departmentId' => $dept->department_id])
        {{-- <livewire:department-data, :departmentId= "$dept->department_id" /> --}}

    </div>
  </div>
{{-- </div> --}}

</section>
