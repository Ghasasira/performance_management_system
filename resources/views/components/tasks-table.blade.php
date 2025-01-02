

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

    <!-- Floating Action Button -->
    <div class="fixed bottom-0 right-0 m-4 bg-blue-500 text-white p-3 rounded-full shadow-lg block md:hidden">
        <div data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </div>
    </div>

    @if (count($data)>0)
           <!-- Table for larger screens -->
           <div class="hidden md:block align-middle inline-block min-w-full shadow overflow-x-auto bg-white shadow-dashboard md:px-8 pt-3 rounded-bl-lg rounded-br-lg">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-2 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">No.</th>
                        <th class="px-4 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Task</th>
                        <th class="px-4 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Timeline</th>
                        <th class="px-4 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Weight</th>
                        <th class="px-4 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Score</th>
                        <th class="px-4 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Status</th>
                        <th class="px-4 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Progress</th>
                        <th class="px-4 py-3 border-b-2 border-gray-300"></th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @for($i = 0; $i < count($data); $i++)
                        <tr>
                            <td class="px-2 py-4 whitespace-no-wrap border-b border-gray-500">
                                <div class="text-sm leading-5 text-gray-800">{{ $i + 1 }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-no-wrap border-b border-gray-500">
                                <div class="text-sm leading-5 text-blue-900">{{ $data[$i]->title }}</div>
                            </td>
                            <td class="px-4 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $data[$i]->deadline }}</td>
                            <td class="px-4 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $data[$i]->weight }}</td>
                            <td class="px-4 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">{{ $data[$i]->score }}</td>
                            <td class="px-4 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                                <span class="relative inline-block px-2 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative text-xs">{{ $data[$i]->status }}</span>
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">
                                <div class="progress">
                                    @php
                                        $percentage = ($data[$i]->score / $data[$i]->weight) * 100;
                                        $progressBarClass = '';

                                        if ($percentage < 25) {
                                            $progressBarClass = 'bg-orange-500'; // Below 25%: Orange
                                        } elseif ($percentage < 65) {
                                            $progressBarClass = 'bg-blue-500'; // Below 70%: Blue
                                        } elseif ($percentage > 64) {
                                            $progressBarClass = 'bg-green-500'; // Above 70%: Green
                                        }
                                    @endphp
                                    {{-- <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $data[$i]->score }}" aria-valuemin="0" aria-valuemax="{{ $data[$i]->score }}">
                                    </div> --}}
                                    <div class="progress-bar {{ $progressBarClass }}" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $data[$i]->score }}" aria-valuemin="0" aria-valuemax="{{ $data[$i]->weight }}">
                                        {{-- <span class="sr-only">{{ $percentage }}% Complete</span> --}}
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-right border-b border-gray-500 text-sm leading-5">
                                <div class="flex items-center">
                                {{-- <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none" type="button" onclick="location.href = '{{ route('tasks.show', $data[$i]) }}'">View Details</button> --}}
                                {{-- <button
                                class="rounded border border-slate-300 py-2.5 px-1 text-center text-xs font-semibold text-slate-600 transition-all hover:opacity-75 focus:ring focus:ring-slate-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                type="button">
                                    Details
                                </button> --}}
                                <!-- View Button -->
                                <button type="button" class="text-white bg-green-500 hover:bg-green-900 rounded p-1 mx-1 h-10 w-10" aria-label="View Task"
                                onclick="location.href = '{{ route('tasks.show', $data[$i]) }}'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                    <circle cx="16" cy="16" r="4" fill="white"/>
                                    <path fill="white" d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68M16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5"/>
                                </svg>
                                </button>

                                <!-- Edit Button -->
                                <button class=" h-10 w-10 p-1 mx-1 select-none rounded-lg text-white bg-blue-500 hover:bg-blue-700 align-middle font-sans text-xs font-medium uppercase transition-all active:bg-blue-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none" type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#editTask-{{ $data[$i]->id }}"
                                data-subtask-title="{{ $data[$i]->title }}"
                                data-subtask-id="{{ $data[$i]->id }}"
                                aria-label="Edit Task">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="w-8 h-6">
                                    <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z"></path>
                                </svg>
                                </button>


                                <!--Edit Modal -->
                                
                                    <div class="modal fade m-1 text-center" id="editTask-{{ $data[$i]->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editTaskLabel-{{ $data[$i]->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('tasks.edit', $data[$i]->id) }}" method="PUT" onsubmit="disableSubmitButton()">
                                                @csrf    
                                                    <div class="relative px-4 py-10 mx-0 shadow rounded-3xl sm:p-10">
                                                        <div class="max-w-md mx-auto">
                                                        <div class="flex items-center space-x-5">
                                                            <div class="h-14 w-14 bg-yellow-200 rounded-full flex flex-shrink-0 justify-center items-center text-yellow-500 text-2xl font-mono">i</div>
                                                            <div class="block pl-2 font-semibold text-xl self-start text-gray-700">
                                                            <h2 class="leading-relaxed">Edit A Task</h2>
                                                            <p class="text-sm text-gray-500 font-normal leading-relaxed">Please ensure you've clearly discussed this task with your superviser.</p>
                                                            </div>
                                                        </div>
                                                        <div class="divide-y divide-gray-200">
                                                            <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                                                            <div class="flex flex-col">
                                                                <label class="leading-loose">Task Title</label>
                                                                <input id="title" name="title" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="Task title" required value="{{$data[$i]->title}}">
                                                            </div>
                                                            <div class="flex flex-col">
                                                                <label class="leading-loose">Event Description</label>
                                                                <textarea id="description" name="description" rows="4" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" required >{{$data[$i]->description}}</textarea>
                                                            </div>
                                                            <div class="md:flex md:items-center md:justify-between">
                                                                <div class="flex flex-col">
                                                                <label class="leading-loose">Task Weight</label>
                                                                <div class="relative focus-within:text-gray-600 text-gray-400">
                                                                    <input id="weight" name="weight" type="numbers" class="pr-4 pl-10 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" required value="{{$data[$i]->weight}}">
                                                                    {{-- <div class="absolute left-3 top-2">
                                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                                    </div> --}}
                                                                </div>
                                                                </div>
                                                                <div class="flex flex-col">
                                                                <label class="leading-loose">Deadline</label>
                                                                <input type="date" id="deadline" name="deadline" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" value="{{$data[$i]->deadline}}">
                                                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" id="user_id" name="user_id" value={{$user}}>
                                                            <div class="pt-4 flex items-center space-x-4">
                                                                <button class="flex justify-center items-center w-full text-gray-900 px-4 py-3 rounded-md focus:outline-none" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" >
                                                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Cancel
                                                                </button>
                                                                <button id="submit-button" class="bg-blue-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none"  type="submit" >Save</button>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    {{-- </div> --}}
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                

                                {{-- delete button --}}
                                <form action="{{ route('tasks.destroy', [$data[$i]->id]) }}" method="POST" onsubmit="return confirm('Are You sure you want to delete task?');">
                                    {{-- <div name="trigger"> --}}
                                        @csrf
                                        @method('DELETE')
                                
                                    <button type="submit" class="text-white bg-red-500 hover:bg-red-700 rounded h-10 w-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 flex items-center text-white mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                                {{-- <div class="ms-3 relative">
                                    <div align="right" width="48">
                                        <div name="trigger">
                                            
                                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none transition"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addComment-{{ $data[$i]->id }}"
                                            data-subtask-title="{{ $data[$i]->title }}"
                                            data-subtask-id="{{ $data[$i]->id }}"
                                            
                                            >
                                                <img src="\assets\3dots.svg" alt="Icon description" class="h-6">                                             
                                            </button>
                                        </div>
                                        
                                            <!-- Add Comment Modal -->
                                            <div class="modal fade" id="addComment-{{ $data[$i]->id }}" tabindex="-1" aria-labelledby="addCommentLabel-{{ $data[$i]->id }}" >
                                                <div class="modal-dialog">
                                                    <form action="{{ route('tasks.comments.store', $data[$i]->id) }}" method="POST" id="approveForm-{{ $data[$i]->id }}">
                                                        @csrf
                                                         
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="addCommentLabel-{{ $data[$i]->id }}">{{$data[$i]->title}}</h1>
                                                            </div>
                                                            <div class="modal-body">
                                                                <input type="text" name="subject" placeholder="Subject" class="block text-sm py-3 px-4 rounded-lg w-full border outline-purple-500" required/>
                                                                <textarea
                                                                    id="comment"
                                                                    name="comment"
                                                                    class="w-full px-3 py-2 mt-2 rounded-sm border border-gray-300 focus:outline-none border-solid focus:border-dashed resize-none"
                                                                    placeholder="Type Comment..."
                                                                    rows="5"
                                                                    required
                                                                ></textarea>
                                                                <input type="hidden" name="task_id" value="{{ $data[$i]->id }}" required>
                                                                <input type="hidden" name="from" value="djfhghh">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>  
                                            
                                                                                                        
                                        
                                        
                                        </div>
                                </div> --}}
                                </div>

                            </div>
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
                        <div>
                            <div class="">
                            <div class="relative py-2 w-full">
                              <div class=" w-full flex justify-content-end t-0 right-0 absolute">
                                <span class="inline-block px-2 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden class="bg-green-200 rounded-full px-2 py-1 text-xs">{{ $item->status }}</span>
                                </span>
                              </div>
                              <div class="">
                                <div class="text-sm leading-5 text-gray-800 font-medium">{{ $item->title }}</div>
                                </div>
                            </div>
                            </div>

                            {{-- <div class="flex justify-content-end item-start h-[40px] mt-0">
                                <span class="inline-block px-2 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden class="bg-green-200 opacity-50 rounded-full px-2 py-1 text-xs">{{ $item->status }}</span>
                                </span>
                            </div>
                            <div class="">
                                <div class="text-sm leading-5 text-gray-800 font-medium">{{ $item->title }}</div>
                            </div> --}}
                        </div>
                        <div class="flex w-full justify-start mt-2">
                            <div class="text-sm leading-5 text-gray-600 mr-2">Weight: <span class="font-bold text-black">{{ $item->weight }}</span></div>

                            <div class="text-sm leading-5 text-gray-600 ml-2">Deadline: <span class="font-bold text-black">{{ $item->deadline }}</span></div>
                        </div>
                        <div class="text-sm leading-5 text-gray-600 mt-2">{{ $item->description }}</div>
                        <div class="mt-2">
                            <div class="progress">
                                @php
                                   $percentage = ($item->score / $item->weight) * 100;
                                        $progressBarClass = '';

                                        if ($percentage < 25) {
                                            $progressBarClass = 'bg-orange-500'; // Below 25%: Orange
                                        } elseif ($percentage < 65) {
                                            $progressBarClass = 'bg-blue-500'; // Below 70%: Blue
                                        } elseif ($percentage > 64) {
                                            $progressBarClass = 'bg-green-500'; // Above 70%: Green
                                        }
                                @endphp
                                <div class="progress-bar {{ $progressBarClass }}" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $item->score }}" aria-valuemin="0" aria-valuemax="{{ $item->score }}">
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
  <div class="modal fade m-1" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <form action="{{ route('tasks.store') }}" method="POST" onsubmit="disableSubmitButton()">
            @csrf    
            {{-- <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12"> --}}
                {{-- <div class="relative py-3 sm:max-w-xl sm:mx-auto"> --}}
                <div class="relative px-4 py-10 mx-0 shadow rounded-3xl sm:p-10">
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
                            <input id="title" name="title" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="Task title" required>
                        </div>
                        <div class="flex flex-col">
                            <label class="leading-loose">Event Description</label>
                            <textarea id="description" name="description" rows="4" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="Description"  required></textarea>
                        </div>
                        <div class="md:flex md:items-center md:justify-between">
                            <div class="flex flex-col">
                            <label class="leading-loose">Task Weight</label>
                            <div class="relative focus-within:text-gray-600 text-gray-400">
                                <input id="weight" name="weight" type="numbers" class="pr-4 pl-10 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="xx" required>
                                {{-- <div class="absolute left-3 top-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div> --}}
                            </div>
                            </div>
                            <div class="flex flex-col">
                            <label class="leading-loose">Deadline</label>
                            <input type="date" id="deadline" name="deadline" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="deadline" required>
                            
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="user_id" name="user_id" value={{$user}}>
                        <div class="pt-4 flex items-center space-x-4">
                            <button class="flex justify-center items-center w-full text-gray-900 px-4 py-3 rounded-md focus:outline-none" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" >
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Cancel
                            </button>
                            <button id="submit-button" class="bg-blue-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none"  type="submit" >Create</button>
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

<script>
    function disableSubmitButton() {
        document.getElementById('submit-button').disabled = true;
    }
</script>
{{-- </div> --}}

