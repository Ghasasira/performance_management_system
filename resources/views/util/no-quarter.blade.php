<x-app-layout>
    <x-slot name="header">
        <!-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2> -->
    </x-slot>

    <div class="py-12 px-2">
        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="h-3/5 w-screen bg-gray-50 flex items-center py-8">
                    <div class="container flex flex-col md:flex-row items-center justify-between px-5 text-gray-700">
                            <div class="w-full lg:w-1/2 mx-8">
                                <div class="lg:text-5xl md:text-3xl text-1xl text-blue-500 font-dark font-bold mb-8">No Quarter Running Currently</div>
                            <!-- <p class="text-2xl md:text-3xl font-light leading-normal mb-8">
                                Sorry we couldn't get the data you're' looking for
                            </p> -->
                            
                            <a href="/history" class=" hidden md:block px-5 inline py-3 text-sm font-medium leading-5 shadow-2xl text-white transition-all duration-400 border border-transparent rounded-lg focus:outline-none bg-blue-600 active:bg-red-600 hover:bg-red-700">
                                Checkout History
                            </a>
                    </div>
                        <div class="hidden md:block w-full lg:flex lg:justify-end lg:w-1/2 mx-5 my-5">
                            <div class="h-1/2">
                                <img src="assets\empty-folder.png" class="" alt="data not yet submitted">
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>