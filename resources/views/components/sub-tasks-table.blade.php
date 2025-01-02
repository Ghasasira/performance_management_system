<div class="p-6 lg:p-8 bg-white border-b border-gray-200 overflow-x-auto">
    <div>
        <h1 class="mt-8 text-2xl font-medium text-gray-900 mt-2 mb-5">
            {{$task->title}}
        </h1>
    </div>

    <div class="md:max-h-[50vh] min-w-full flex items-center justify-center md:px-4 mt-10">
        <div class="bg-white w-full ">
            <div class="p-6">
                @foreach(['Status' => $task->status, 'Weight' => $task->weight, 'Score' => $task->score, 'Description' => $task->description] as $label => $value)
                <div class="grid grid-cols-2 hover:bg-gray-50 space-y-1 md:space-y-0 md:py-3">
                    <p class="text-gray-600">{{$label}}</p>
                    <p class="text-gray-800 font-semibold">{{$value}}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="-my-4 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 pr-10 lg:px-8">
        <div class="flex justify-between w-full">
            <h3 class="mt-3 mb-3 text-2xl font-medium text-gray-900">SubTasks</h3>
            <div class="mt-3 mb-3">
                <x-secondary-button data-bs-toggle="modal" data-bs-target="#addSubTaskModal" class="hidden sm:block">
                    {{ __('Add New Subtask') }}
                </x-secondary-button>
            </div>
        </div>
    </div>

        <!-- Floating Action Button -->
        <div class="fixed bottom-0 right-0 m-4 bg-blue-500 text-white p-3 rounded-lg shadow-lg block md:hidden">
            <div data-bs-toggle="modal" data-bs-target="#addSubTaskModal">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
        </div>
    
    <div class="container mx-auto p-1 w-full">
        <!-- Cards for small screens -->
        <div class="block md:hidden space-y-4 mb-2">
            @foreach ($task->subtasks as $index => $subtask)
            <div class="bg-white p-1 rounded-lg shadow-md w-full">
                <div class="flex justify-between border-b pb-2 mb-2">
                    <h3 class="text-lg font-semibold text-blue-500">{{ $subtask->title }}</h3>
                    <span class="relative inline-block max-h-[30px] px-3 py-1 font-semibold text-green-900 leading-tight">
                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                        <span class="relative text-xs">{{ $subtask->status }}</span>
                    </span>
                </div>
                <div class="mb-2">
                    <p class="text-gray-600 font-medium">Weight: <span class="text-gray-800">{{ $subtask->weight }}</span></p>
                </div>
                <div class="mb-2">
                    <p class="text-gray-600 font-medium">Score: <span class="text-gray-800">{{ $subtask->score }}</span></p>
                </div>
                <div class="flex justify-between items-end">
                    <button class="px-1 py-1 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none"
                        type="button" 
                        onclick="location.href = '{{ route('subtask.attachments', $subtask->id) }}'">
                        Attachments
                    </button>
                    @if ($subtask->status != 'approved')
                        @if ($subtask->status == 'pending')
                            <a href="{{ url('tasks/subtasks/submit/'.$subtask->id) }}">
                                <button class="rounded-lg bg-blue-500 py-2 px-2 font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:shadow-lg focus:opacity-85 active:opacity-85">
                                    Submit
                                </button>
                            </a>
                        @else
                            <button class="rounded-lg bg-green-500 py-2 px-2 font-sans text-xs font-bold uppercase text-white shadow-md disabled:opacity-50">
                                Submitted
                            </button>
                        @endif
                    @else
                    <a href="{{ url('tasks/subtasks/submit/'.$subtask->id) }}">
                        <button class="rounded-lg bg-blue-500 py-2 px-2 font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:shadow-lg focus:opacity-85 active:opacity-85">
                            Re-submit
                        </button>
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Table for medium and larger screens -->
        <div class="hidden md:block">
            <div class="align-middle inline-block min-w-full shadow overflow-x-auto bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
                <table class="min-w-full">
                    <thead>
                        <tr>
                            @foreach(['No.', 'Sub Task', 'Weight', 'Score', 'Status', ''] as $heading)
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">{{$heading}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($task->subtasks as $index => $subtask)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                <div class="text-sm leading-5 text-gray-800">#{{ $index + 1 }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                                <div class="text-sm leading-5 text-blue-900">{{ $subtask->title }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $subtask->weight }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">{{ $subtask->score }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                                <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                    <span class="relative text-xs">{{ $subtask->status }}</span>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-500 text-sm leading-5">
                                <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none"
                                    type="button" 
                                    onclick="location.href = '{{ route('subtask.attachments', $subtask->id) }}'">
                                    View Attachments
                                </button>
                            </td>
                            @if ($subtask->status != 'approved')
                                @if ($subtask->status == 'pending')
                                <td>
                                    <div class="flex items-center">
                                        <a href="{{ url('tasks/subtasks/submit/'.$subtask->id) }}">
                                            <button class="rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:shadow-lg focus:opacity-85 active:opacity-85">
                                                Submit
                                            </button>
                                        </a>

                                        <form action="{{ route('tasks.subtasks.destroy', [$task->id, $subtask->id]) }}" method="POST" onsubmit="return confirm('Are You sure you want to delete subtask?');">
                                            {{-- <div name="trigger"> --}}
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none transition">
                                                    {{-- <img src="\assets\delete.svg" alt="Icon description" class="h-16">                                              --}}
                                                    <button class="m-1 rounded-lg bg-red-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:shadow-lg focus:opacity-85 active:opacity-85">
                                                        Delete
                                                    </button>
                                                </button>
                                            {{-- </div> --}}
                                        </form>
                                    </div>
                                </td> 
                                @else
                                <td>
                                    <button class="rounded-lg bg-green-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md disabled:opacity-50">
                                        Submitted
                                    </button>  
                                </td> 
                                @endif 
                            @else
                            <td>
                                <a href="{{ url('tasks/subtasks/submit/'.$subtask->id) }}">
                                    <button class="rounded-lg bg-gray-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:shadow-lg focus:opacity-85 active:opacity-85">
                                        Re-submit
                                    </button>
                                </a>
                            </td>
                            @endif  
                        </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
</div>
</div>

{{-- ................. --}}

<!-- New Subtask Modal -->
<div class="modal fade" id="addSubTaskModal" tabindex="-1" aria-labelledby="addSubTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('tasks.subtasks.store',$task->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addSubTaskModalLabel">New Subtask</h1>
                </div>
                <div class="modal-body">
                    <input type="text" name="title" placeholder="Subtask Title" class="block text-sm py-3 px-4 rounded-lg w-full border outline-purple-500" required />
                    <input type="number" name="weight" placeholder="Weight" class="block text-sm py-3 px-4 rounded-lg w-full border outline-purple-500 mt-4" required />
                    {{-- <textarea name="description" placeholder="Description" class="block text-sm py-3 px-4 rounded-lg w-full border outline-purple-500 mt-4" required></textarea> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

