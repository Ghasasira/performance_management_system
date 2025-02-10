<div class="m-2 ">
    @foreach ($data as $item )
    <div class="mt-2 mb-2 py-1 bg-white shadow rounded">

        <div class="flex ">
            <span class="border-b-2 border-gray-300 w-full flex justify-between items-center">
                {{-- <h2>Task:</h2> --}}
                <h2 class="font-bold text-2xl m-2">{{$item["task"]->title}}</h2>

                <div class="text-nowrap">
                    <span>
                        Score :
                    </span>
                    <span class="px-2 py-1 text-nowrap rounded-lg bg-red-50 text-orange-500 text-2xl">
                        {{$item["task"]->score}} / {{$item["task"]->weight}}
                    </span>
                </div>
                {{-- <div class="relative rounded-xl text-gray-700 shadow-md p-1 m-1">
                    <h2 class="font-bold text-2xl">X/Y</h2>
                </div> --}}
            </span>

        </div>

        <div class="m-2 flex">
            <p class="mt-2 text-gray-600">
                {{$item["task"]->description}}
            </p>
        </div>

        <div class="p-2 flex justify-between items-center">
            <div class="flex">
                <div class="p-2 pt-0">
                @if (strtolower($item["task"]->status) == "submitted")
                    <button class="approve-button middle none center mr-4 rounded-lg bg-green-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    data-bs-toggle="modal"
                    data-bs-target="#approveModal-{{ $item["task"]->id }}"
                    data-subtask-title="{{ $item["task"]->title }}"
                    data-subtask-id="{{ $item["task"]->id }}"
                    >
                    {{-- data-bs-target="#approveModal-{{ $subtask->id }}"
                    data-subtask-title="{{ $subtask->title }}"
                    data-subtask-id="{{ $subtask->id }}" --}}
                        Award Score
                    </button>
                    @elseif ( strtolower($item["task"]->status) == "graded")
                    <button class="approve-button middle none center mr-4 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    data-bs-toggle="modal"
                    data-bs-target="#approveModal-{{ $item["task"]->id }}"
                    data-subtask-title="{{ $item["task"]->title }}"
                    data-subtask-id="{{ $item["task"]->id }}"
                    >
                    {{-- data-bs-target="#approveModal-{{ $subtask->id }}"
                    data-subtask-title="{{ $subtask->title }}"
                    data-subtask-id="{{ $subtask->id }}" --}}
                        Adjust result
                    </button>
                    @else
                    <button class="middle none center mr-4 rounded-lg bg-red-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all disabled:shadow-none" disabled
                    >
                    No Submission
                    </button>
                    @endif
                    <!-- Approve Modal -->
                    <div class="modal fade" id="approveModal-{{ $item["task"]->id }}" tabindex="-1" aria-labelledby="approveModalLabel-{{ $item["task"]->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('task.score', ["task" =>$item["task"]->id]) }}" method="POST" id="approveForm-{{ $item["task"]->id }}">
                                {{--  --}}
                                @csrf
                                @method('PATCH')
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="approveModalLabel-{{ $item["task"]->id }}">Approve Submission for {{$item["task"]->title}}</h1>
                                    </div>
                                    <div class="modal-body">
                                        <input type="number" name="score" placeholder="Score" class="block text-sm py-3 px-4 rounded-lg w-full border outline-purple-500" />
                                        <div class=" flex text-sm text-blue-600 mt-1 mb-2">
                                            {{-- <span class="font-medium text-red-400">Hint!:::</span> --}}
                                            Task to be scored out of {{$item["task"]->weight}}.
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Approve</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <button class="px-1 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none"
                type="button" onclick="location.href = '{{ route('task.attachments', $item["task"]->id) }}'"
                >View Attachments</button>
            </div>
        {{-- </div> --}}

            {{-- delete and differ buttons --}}
            <div class="flex items-center">
                {{-- <a href="{{ url('tasks.destroy', $item["task"]->id) }}">
                    <button class="rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:shadow-lg focus:opacity-85 active:opacity-85">
                        Differ
                    </button>
                </a> --}}
                <div>
                    <form action="{{ route('tasks.differ', $item["task"]->id) }}" method="POST" onsubmit="return confirm('Are You sure you want to differ task?');">
                        {{-- <div name="trigger"> --}}
                            @csrf
                            @method('POST')
                            <button type="submit" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none transition">
                                {{-- <img src="\assets\delete.svg" alt="Icon description" class="h-16">                                              --}}
                                <button class="m-1 rounded-lg bg-blue-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md transition-all hover:shadow-lg focus:opacity-85 active:opacity-85">
                                    Differ
                                </button>
                            </button>
                        {{-- </div> --}}
                    </form>
                </div>

                <div>
                    <form action="{{ route('tasks.destroy', $item["task"]->id) }}" method="POST" onsubmit="return confirm('Are You sure you want to delete task?');">
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
            </div>
        </div>

    </div>

    @endforeach
</div>
