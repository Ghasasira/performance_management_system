

<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <div class="flex justify-between w-full">
        <h1 class="mt-8 text-2xl font-medium text-gray-900 mb-5">
            {{$quarter}}
        </h1>
        <div class="mt-5">
            {{-- <a href="#" data-toggle="modal" data-target="#ModalCreate"> --}}
                <x-secondary-button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="hidden sm:block">
                    {{-- </x-secondary-button> --}}
                    {{-- <x-secondary-button wire:click="createNewTask" wire:loading.attr="disabled"> --}}
                        {{ __('Create New Task') }}
                        {{-- <x-secondary-button wire:click="createNewTask" wire:loading.attr="disabled"> --}}
                    </x-secondary-button>

        </div>
    </div>

    @if (count($data)>0)
           <!-- Table for larger screens -->
           <div class="hidden md:block align-middle inline-block min-w-full shadow overflow-x-auto bg-white shadow-dashboard md:px-8 pt-3 rounded-bl-lg rounded-br-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">No.</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Task</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Timeline</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Weight</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Status</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Evaluation Score</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Progress</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300"></th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @for($i = 0; $i < count($data); $i++)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                <div class="text-sm leading-5 text-gray-800">{{ $i + 1 }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                <div class="text-sm leading-5 text-blue-900">{{ $data[$i]->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $data[$i]->deadline }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $data[$i]->weight }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                                <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative text-xs">{{ $data[$i]->status }}</span>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">{{ $data[$i]->score }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">
                                <div class="progress">
                                    @php
                                        $percentage = ($data[$i]->score / $data[$i]->weight) * 100;
                                    @endphp
                                    <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $data[$i]->score }}" aria-valuemin="0" aria-valuemax="{{ $data[$i]->score }}">
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-500 text-sm leading-5">
                                <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none" type="button" onclick="location.href = '{{ route('tasks.show', $data[$i]) }}'">View Details</button>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <!-- Cards for smaller screens -->
            <div class="block md:hidden">
                @foreach ($data as $item)
                <a href="{{ route('tasks.show', $item) }}">
                    <div class="border rounded-lg pl-4 pb-2 pt-1 pr-1 mb-4 bg-white shadow cursor-pointer">
                        <div class="flex justify-content-end item-start mt-0">
                            <span class="inline-block px-2 py-1 font-semibold text-green-900 leading-tight">
                                <span aria-hidden class="bg-green-200 opacity-50 rounded-full px-2 py-1 text-xs">{{ $item->status }}</span>
                            </span>
                        </div>
                        <div class="">
                            <div class="text-sm leading-5 text-gray-800 font-medium">{{ $item->title }}</div>
                            {{-- <div class="mt-2">
                                
                            </div> --}}
                        </div>
                        <div class="text-sm leading-5 text-gray-600 mt-2">Deadline: {{ $item->deadline }}</div>
                        <div class="text-sm leading-5 text-gray-600 mt-2">{{ $item->description }}</div>
                        <div class="mt-2">
                            <div class="progress">
                                @php
                                    $percentage = ($item->score / $item->weight) * 100;
                                @endphp
                                <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $item->score }}" aria-valuemin="0" aria-valuemax="{{ $item->score }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
            </div>
            <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between mt-4 work-sans">
        </div>
        <div class="mt-4">
            {{$data->links()}}
        </div>
 
    @else
        <div class="flex w-full justify-center">
            <h1 class="text-blue-600 hover:underline">
                No tasks created for this Quarter yet
            </h1>
            {{-- <h3 class="text-red ">
                please note that your current device 
            </h3> --}}
        </div>
    @endif
    

        
  
  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <form action="{{ route('tasks.store') }}" method="POST">
            @csrf    
            {{-- <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12"> --}}
                {{-- <div class="relative py-3 sm:max-w-xl sm:mx-auto"> --}}
                <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
                    <div class="max-w-md mx-auto">
                    <div class="flex items-center space-x-5">
                        <div class="h-14 w-14 bg-yellow-200 rounded-full flex flex-shrink-0 justify-center items-center text-yellow-500 text-2xl font-mono">i</div>
                        <div class="block pl-2 font-semibold text-xl self-start text-gray-700">
                        <h2 class="leading-relaxed">Create A Task</h2>
                        <p class="text-sm text-gray-500 font-normal leading-relaxed">Please ensure you've clearly discussed this task with your superviser.</p>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                        <div class="flex flex-col">
                            <label class="leading-loose">Task Title</label>
                            <input id="title" name="title" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="Task title">
                        </div>
                        <div class="flex flex-col">
                            <label class="leading-loose">Event Description</label>
                            <textarea id="description" name="description" rows="4" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="Description"></textarea>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex flex-col">
                            <label class="leading-loose">Task Weight</label>
                            <div class="relative focus-within:text-gray-600 text-gray-400">
                                <input id="weight" name="weight" type="numbers" class="pr-4 pl-10 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="10">
                                {{-- <div class="absolute left-3 top-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div> --}}
                            </div>
                            </div>
                            <div class="flex flex-col">
                            <label class="leading-loose">Deadline</label>
                            <input type="date" id="deadline" name="deadline" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="deadline">
                            
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="user_id" name="user_id" value={{$user}}>
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
{{-- </div> --}}

