<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quarters') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12 h-full"> 
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4"> 
            @if ($current == null)
            {{-- <div class="grid grid-cols-1 md:grid-cols-1 gap-4">   --}}
                <div class="flex justify-center">
                    <div class="w-1/2 bg-white overflow-hidden rounded-lg shadow-xl flex flex-col items-center justify-center py-8 px-12">  
                        <h2 class="text-3xl font-medium text-gray-800 mb-4">No Quarter Running</h2>  
                            <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none", type="button" data-bs-toggle="modal" data-bs-target="#staticBackdropp">START NEW QUARTER</button>
                            {{-- onclick="location.href = '{{ route('tasks.show', $data[$i]) }}'" --}}
                    </div>
                </div>
            @else
             
                <div class="bg-white overflow-hidden rounded-lg shadow-xl flex flex-col items-center justify-center py-8 px-12">  
                    <h2 class="text-3xl font-medium text-gray-800 mb-4">{{$current->name}}</h2>  
                    <p class="text-gray-600 text-lg">{{$current->start_date}}  To  {{$current->end_date}}</p>
                </div>
                    <a href="{{route('quarter.edit', $current) }}">
                        <button class="w-full px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none", type="button" >END QUARTER</button>
                        {{-- onclick="location.href = '{{ route('tasks.show', $data[$i]) }}'" --}}
                    </a>
             
            @endif 
        </div> 
        </div>

{{-- Start  Quater Model--}}
        <div class="modal fade" id="staticBackdropp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdroppLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                  <form action="{{ route('quarter.store') }}" method="POST">
                    @csrf    
                    {{-- <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12"> --}}
                        {{-- <div class="relative py-3 sm:max-w-xl sm:mx-auto"> --}}
                        <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
                            <div class="max-w-md mx-auto">
                            <div class="flex items-center space-x-5">
                                {{-- <div class="h-14 w-14 bg-yellow-200 rounded-full flex flex-shrink-0 justify-center items-center text-yellow-500 text-2xl font-mono">i</div> --}}
                                <div class="block pl-2 font-semibold text-xl self-start text-gray-700">
                                    <h2 class="leading-relaxed">New Quarter</h2>
                                    {{-- <p class="text-sm text-gray-500 font-normal leading-relaxed">Please ensure you've clearly discussed this task with your superviser.</p> --}}
                                </div>
                            </div>
                            <div class="divide-y divide-gray-200">
                                <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                                <div class="flex flex-col">
                                    <label for="name" class="leading-loose">Quarter Title</label>
                                    <input id="name" name="name" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="Quarter title">
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="flex flex-col">
                                        <label for="start_date" class="leading-loose">Start Date</label>
                                        <input type="date" id="start_date" name="start_date" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="deadline"> 
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="end_date" class="leading-loose">End Date</label>
                                        <input type="date" id="end_date" name="end_date" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="deadline"> 
                                    </div>
                                </div>
                            </div>
                            {{-- <input type="hidden" id="user_id" name="user_id" value={{$user}}> --}}
                                <div class="pt-4 flex items-center space-x-4">
                                    <button class="flex justify-center items-center w-full text-gray-900 px-4 py-3 rounded-md focus:outline-none" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" >
                                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Cancel
                                    </button>
                                    <button class="bg-blue-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none"  type="submit" >Create</button>
                                </div>
                            </div>
                            </div>
                        </div>
                        {{-- </div> --}}
                </form>
              </div>
            </div>
          </div>

    </div>
</x-app-layout>