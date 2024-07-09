{{-- <div class="p-6 lg:p-8 bg-white border-b border-gray-200"> --}}
    {{-- <div class="flex justify-between w-full">
        <h1 class="mt-8 text-2xl font-medium text-gray-900 mb-5">
            Submissions
        </h1>
        
    </div> --}}

    <div class="flex flex-row align-middle inline-block min-w-full min-h-screen shadow overflow-hidden bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
        @foreach ($data as $supervisee)
            <!-- component -->
            <div>
                <a href = '{{ route('supervisees.show', $supervisee) }}'>
                    <div class="relative flex m-2 flex-col rounded-xl bg-white text-gray-700 shadow-md w-32">  <div class="relative mx-2 mt-2 h-15 rounded-xl bg-white bg-clip-border text-gray-700 shadow-lg">
                        <img src="https://th.bing.com/th/id/R.47cecf6ce91d73af7900067efeaacb63?rik=%2btKMy%2fBRVLblKA&pid=ImgRaw&r=0" alt="profile-picture" />
                      </div>
                      <div class="p-2 text-center">  <h4 class="mb-2 block font-sans text-lg font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased">
                          {{$supervisee->first_name}} {{$supervisee->last_name}}
                        </h4>
                        <p class="block bg-gradient-to-tr from-pink-600 to-pink-400 bg-clip-text font-sans text-sm font-medium leading-relaxed text-transparent antialiased">
                          Staff
                        </p>
                      </div>
                    </div>
                    
                </a>
            </div>
        @endforeach
    </div>

{{-- </div> --}}
