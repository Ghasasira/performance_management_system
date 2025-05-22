<div class="container mx-auto px-4 py-6">
    <div>
        <livewire:supervisee-component :userId="$supervisee"/>
    </div>

    {{-- @foreach ($data as $item)
    <div class="mb-6 bg-white shadow-lg rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1">
        <div class="p-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-semibold text-gray-800 tracking-tight">{{$item["task"]->title}}</h2>

                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Score:</span>
                    <span class="px-3 py-1 rounded-full bg-orange-50 text-orange-600 font-medium text-lg flex items-center">
                        {{$item["task"]->score}} / {{$item["task"]->weight}}
                        <span class="ml-2 cursor-help" title="This is the score for the task. The first number represents the awarded score, and the second number represents the total possible score.">
                            <i class="fas fa-info-circle text-blue-500 hover:text-blue-700 transition-colors"></i>
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <div class="p-4">
            <p class="text-gray-700 leading-relaxed mb-4">
                {{$item["task"]->description}}
            </p>

            <div class="flex justify-between items-center">
                <div class="flex space-x-3">
                    @if (strtolower($item["task"]->status) == "submitted")
                        <button class="btn btn-success group"
                            data-bs-toggle="modal"
                            data-bs-target="#approveModal-{{ $item["task"]->id }}"
                            data-subtask-title="{{ $item["task"]->title }}"
                            data-subtask-id="{{ $item["task"]->id }}">
                            <span class="group-hover:scale-105 transition-transform">Award Score</span>
                        </button>
                    @elseif (strtolower($item["task"]->status) == "graded")
                        <button class="btn btn-info group"
                            data-bs-toggle="modal"
                            data-bs-target="#approveModal-{{ $item["task"]->id }}"
                            data-subtask-title="{{ $item["task"]->title }}"
                            data-subtask-id="{{ $item["task"]->id }}">
                            <span class="group-hover:scale-105 transition-transform">Adjust Result</span>
                        </button>
                    @else
                        <button class="btn btn-danger" disabled>No Submission</button>
                    @endif

                    <button class="mx-1 btn btn-outline-primary"
                        onclick="location.href = '{{ route('task.attachments', $item["task"]->id) }}'">
                        View Attachments
                    </button>
                </div>

                <div class="flex space-x-3 gap-1">
                    <form action="{{ route('tasks.differ', $item["task"]->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to defer this task?');">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-outline-info">
                            Defer
                        </button>
                    </form>

                    <form action="{{ route('tasks.differ', $item["task"]->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to defer this task?');">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-outline-info">
                            Defer
                        </button>
                    </form>

                    <form action="{{ route('tasks.destroy', $item["task"]->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this task?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <!-- Approve Modal -->
        <div class="modal fade" id="approveModal-{{ $item["task"]->id }}" tabindex="-1" aria-labelledby="approveModalLabel-{{ $item["task"]->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('task.score', ["task" =>$item["task"]->id]) }}" method="POST" id="approveForm-{{ $item["task"]->id }}">
                    @csrf
                    @method('PATCH')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="approveModalLabel-{{ $item["task"]->id }}">Approve Submission for {{$item["task"]->title}}</h1>
                        </div>
                        <div class="modal-body">
                            <input type="number" name="score" placeholder="Score" class="block text-sm py-3 px-4 rounded-lg w-full border outline-purple-500" />
                            <div class=" flex text-sm text-blue-600 mt-1 mb-2">
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
    @endforeach --}}
</div>

<style>
.btn {
    @apply rounded-lg px-4 py-2 font-medium text-sm uppercase tracking-wider transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none;
}
.btn-success { @apply bg-green-500 text-white hover:bg-green-600; }
.btn-info { @apply bg-blue-500 text-white hover:bg-blue-600; }
.btn-danger { @apply bg-red-500 text-white hover:bg-red-600; }
.btn-outline-primary { @apply border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white; }
.btn-outline-info { @apply border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white; }
.btn-outline-danger { @apply border border-red-500 text-red-500 hover:bg-red-500 hover:text-white; }
</style>
