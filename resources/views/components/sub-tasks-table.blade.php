<div class="p-6 lg:p-8 bg-white border-b border-gray-200 overflow-x-auto">
    <div>
        <h1 class="mt-8 text-2xl font-medium text-blue-500 mt-2 mb-5">
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

  <div class="">

    <div class="w-full px-1">

        <div class="-my-4 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 pr-10 lg:px-8">
            <div class="flex justify-between w-full">
                <h3 class="mt-3 mb-3 text-xl font-medium text-blue-500">SubTasks</h3>
                <div class="mt-3 mb-3">
                    <x-secondary-button data-bs-toggle="modal" data-bs-target="#addSubTaskModal" class="hidden sm:block">
                        {{ __('Add New Subtask') }}
                    </x-secondary-button>

                    <x-secondary-button data-bs-toggle="modal" data-bs-target="#addSubTaskModal" class="md:hidden">
                        {{ __('Add') }}
                    </x-secondary-button>
                </div>
            </div>
        </div>



        <div class="container mx-auto p-1 w-full">
            <!-- Table for medium and larger screens -->
            <div class="">
                <div class="align-middle inline-block min-w-full shadow overflow-x-auto bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
                    @if ($task->subtasks->isEmpty())
                        <p class="flex justify-center text-red-500">No subtasks found.</p>
                    @else

                    <table class="min-w-full">
                        <thead>
                            <tr>
                                {{-- @foreach(['No.', 'Sub Task', 'Weight', 'Score', 'Status', ''] as $heading) --}}

                                @foreach(['No.', 'Sub Task', ''] as $heading)
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">{{$heading}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($task->subtasks as $index => $subtask)
                            <tr class="py-2">
                                <td class="px-4 whitespace-no-wrap">
                                    <div class="text-sm leading-5 text-gray-800">{{ $index + 1 }}</div>
                                </td>
                                <td class="px-4">
                                    <div class="text-sm text-blue-900">{{ $subtask->title }}</div>
                                </td>
                                <td class="whitespace-no-wrap">
                                    <div class="inline-flex items-center">
                                        <form action="{{ route('subtasks.submit', [$subtask->id]) }}" method="POST">
                                            @csrf
                                            <label
                                                class="relative flex cursor-pointer items-center rounded-full p-3"
                                                for="checkbox-{{ $subtask->id }}"
                                                data-ripple-dark="true"
                                            >
                                                <input
                                                    type="checkbox"
                                                    name="status"
                                                    class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border border-blue-gray-200 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-pink-500 checked:bg-pink-500 checked:before:bg-pink-500 hover:before:opacity-10"
                                                    id="checkbox-{{ $subtask->id }}"
                                                    value="Submitted"
                                                    @checked($subtask->status === 'Submitted')
                                                    onchange="this.form.submit()"
                                                />
                                            </label>
                                        </form>

                                        <div>

                                            {{-- delete button --}}
                                            <form action="{{ route('tasks.subtasks.destroy', [$task->id, $subtask->id]) }}" method="POST" onsubmit="return confirm('Are You sure you want to delete subtask?');">
                                                {{-- <div name="trigger"> --}}
                                                    @csrf
                                                    @method('DELETE')

                                                <button type="submit" class="rounded p-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z"/></svg>
                                                </button>
                                            </form>
                                        </div>

                                    </div>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <div class="w-full px-1 border-left border-blue-500">
        <div class="-my-4 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 pr-10 lg:px-8">
            <div class="flex justify-between w-full">
                <h3 class="mt-3 mb-3 text-xl font-medium text-blue-500">Attachments</h3>
                <div class="mt-3 mb-3">
                    <x-secondary-button data-bs-toggle="modal" data-bs-target="#addAttachmentModal" class="hidden sm:block">
                        {{ __('Add Attachment') }}
                    </x-secondary-button>
                    <x-secondary-button data-bs-toggle="modal" data-bs-target="#addAttachmentModal" class="md:hidden">
                        {{ __('Add') }}
                    </x-secondary-button>
                </div>
            </div>
        </div>

        <div class="align-middle inline-block min-h-1/4 min-w-full shadow overflow-x-auto bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
            {{-- attachments --}}
            @if($task->attachments->isEmpty())
                    <p class="flex justify-center text-red-500">No attachments found.</p>
                @else
                    <div class="flex flex-col space-y-4">
                        @foreach ($task->attachments as $attachment)
                            <div class="flex items-center space-x-4">
                                <input
                                    type="text"
                                    value="{{ $attachment->file_name}}"
                                    class="h-full w-1/2 rounded-[7px] border border-blue-gray-200 bg-transparent px-3 py-2.5 pr-20 font-sans text-sm font-normal text-blue-gray-700 outline-none transition-all focus:border-2 focus:border-red-500 focus:outline-none"
                                    readonly
                                />
                                <a
                                    href="{{ route('attachments.show', $attachment)}}"
                                    {{-- Storage::url($attachment->link) }}" --}}
                                    target="_blank"
                                    class="rounded bg-green-500 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-white transition-all hover:shadow-lg hover:bg-green-600 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85]"
                                >
                                    View
                                </a>
                                <form action="{{ route('attachments.destroy', $attachment) }}" method="POST" onsubmit="return confirm('Are You sure you want to delete attachment?');">
                                    {{-- <div name="trigger"> --}}
                                        @csrf
                                        @method('DELETE')

                                    <button type="submit" class="text-white hover:bg-red-700 rounded h-10 w-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 flex items-center text-black mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        @endforeach
                    </div>
                @endif
        </div>


    </div>


    {{-- @if (strtolower($task->status) != 'pending') --}}
        <div class="w-full flex justify-end p-2" >
            @if (strtolower($task->status) == 'pending' || strtolower($task->status) == 'inprogress')
                <a href="{{ url('task/submit/'.$task->id) }}">
                    <button class="rounded-lg bg-blue-500 py-2 px-2 font-sans font-bold uppercase text-white shadow-md transition-all hover:shadow-lg focus:opacity-85 active:opacity-85">
                        Submit
                    </button>
                </a>
            @elseif (strtolower($task->status) == 'submitted')
                <button class="rounded-lg bg-green-500 py-2 px-2 font-sans font-bold uppercase text-white shadow-md disabled:opacity-50">
                    Submitted
                </button>
            @elseif (strtolower($task->status) == 'graded')
                <a href="{{ url('task/submit/'.$task->id) }}">
                    <button class="rounded-lg bg-green-500 py-2 px-2 font-sans font-bold uppercase text-white shadow-md disabled:opacity-50">
                        Re-submit
                    </button>
                </a>
            @endif
        </div>
                                {{-- @endif --}}

  </div>
</div>


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
                    <input type="hidden" value=0 name="weight" placeholder="Weight" class="block text-sm py-3 px-4 rounded-lg w-full border outline-purple-500 mt-4" required />
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

<!-- New Attachment Modal -->
<div class="modal fade" id="addAttachmentModal" tabindex="-1" aria-labelledby="addAttachmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('attachments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addAttachmentModalLabel">New Attachment</h1>
                </div>
                <div class="modal-body">
                    <input type="file" name="pdf" id="pdf" class="form-control shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <input type="hidden" name="taskId" value="{{ $task->id }}">
                    <input type="hidden" name="task_title" value="{{ $task->title }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

