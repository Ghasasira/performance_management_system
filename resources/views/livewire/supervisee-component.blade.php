<div>
    @if(session()->has('success'))
        <div class="text-green-500">
            {{ session('success') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="text-red-500">
            {{ session('error') }}
        </div>
    @endif

    <!-- Quarter Selection Dropdown -->
    <div class="mb-6">
        <label for="quarter-select" class="block text-sm font-medium text-gray-700">Select Quarter</label>
        <select
            id="quarter-select"
            wire:model.live="selectedQuarterId"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
        >
            @foreach($quarters as $quarter)
                <option value="{{ $quarter->id }}" @selected($quarter->id == $selectedQuarterId)>
                    {{ $quarter->name }}
                    {{-- ({{ $quarter->start_date->format('M Y') }} - {{ $quarter->end_date->format('M Y') }}) --}}
                    @if($quarter->id == $activeQuarterId) - Active @endif
                </option>
            @endforeach
        </select>
    </div>


    @if(!empty($submittedTasks))
        @foreach ($submittedTasks as $item)
            <div class="mb-6 bg-white shadow-lg rounded-xl overflow-hidden transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1">
                <div class="p-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-3xl font-semibold text-gray-800 tracking-tight max-w-4/5">
                            {{ $item["task"]->title }}
                        </h2>

                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Score:</span>
                            <span class="px-3 py-1 rounded-full bg-orange-50 text-orange-600 font-medium text-lg flex items-center">
                                {{ $item["task"]->score }} / {{ $item["task"]->weight }}
                                {{-- <span class="ml-2 cursor-help" title="This is the score for the task.">
                                    <i class="fas fa-info-circle text-blue-500 hover:text-blue-700 transition-colors"></i>
                                </span> --}}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-4">
                    <p class="text-gray-700 leading-relaxed mb-4">
                        {{ $item["task"]->description }}
                    </p>

                    <div class="flex justify-between items-center">
                        <div class="flex space-x-3">
                            @if (strtolower($item["task"]->status) == "submitted")
                                <button class="btn btn-success" wire:click="awardTask({{ $item['task']->id }})">
                                {{-- wire:click="$set('taskId', {{ $item["task"]->id }})" data-bs-toggle="modal" data-bs-target="#approveModal"> --}}
                                    Award Score
                                </button>
                            @elseif (strtolower($item["task"]->status) == "graded")
                                <button class="btn btn-info" wire:click="awardTask({{ $item['task']->id }})">
                                {{-- wire:click="$set('taskId', {{ $item['task']->id }})" data-bs-toggle="modal" data-bs-target="#approveModal"> --}}
                                    Adjust Score
                                </button>
                            @else
                                <button class="btn btn-danger" disabled>No Submission</button>
                            @endif

                            <button class="mx-1 btn btn-outline-primary"
                                onclick="location.href = '{{ route('task.attachments', $item['task']->id) }}'">
                                View Attachments
                            </button>
                        </div>
                        <div class="flex space-x-3 gap-1">
                                @if ( strtolower($item["task"]->is_approved) == false )
                                <button wire:click="approveTask({{ $item["task"]->id }})" onclick="confirm('Are you sure? Approving the task makes it uneditable') || event.stopImmediatePropagation();" class="btn btn-info">
                                    Approve Task
                                </button>
                                @endIf

                                @if ( strtolower($item["task"]->is_approved) == true )
                                 @if (strtolower($item["task"]->status) == 'deferred')
                                 <button class="btn btn-outline-info">
                                    Deferred
                                </button>
                                 @else
                                 <button wire:click="differTask({{ $item["task"]->id }})" class="btn btn-outline-danger">
                                    Defer
                                </button>
                                 @endif

                                @endif

                                <button wire:click="openEditModal({{ $item["task"]->id }})" class="btn btn-outline-info">
                                    Edit
                                </button>
                                @if ( strtolower($item["task"]->is_approved) == false )
                                <button wire:click="delete({{ $item["task"]->id }})" onclick="confirm('Are you sure?') || event.stopImmediatePropagation();" class="btn btn-outline-danger">
                                    Delete
                                </button>
                                @endif
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    @else
        <p>No tasks submitted for this quarter.</p>
    @endif

<!--score modal -->
@if($isScoreModalOpen)
<div class="modal fade show" id="approveModal" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog">
        <form wire:submit.prevent="scoreTask">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Score {{$selectedTask->title}}</h1>
                    {{-- <button type="button" wire:click="$set('taskId', null)" class="btn-close"></button> --}}
                </div>
                <div class="modal-body">
                    <input type="number" wire:model="score" placeholder="Score"
                           class="block text-sm py-3 px-4 rounded-lg w-full border outline-purple-500" />
                    @error('score')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                    <div class=" flex text-sm text-blue-600 mt-1 mb-2">
                        Task to be scored out of {{$selectedTask->weight}}.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" wire:click="closeModal" class="btn btn-secondary">Close</button>
                    <button type="submit" class="btn btn-primary">Approve</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

{{-- edit modal --}}
@if($isEditModalOpen)
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-xl font-bold mb-4">
            Edit Task
        </h2>
        <form wire:submit.prevent="editTask">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Task Title</label>
                    <input wire:model="title" type="text" class="mt-1 block w-full border rounded-md p-2" required>
                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea wire:model="description" class="mt-1 block w-full border rounded-md p-2" required></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Task Weight</label>
                    <input wire:model="weight" type="number" class="mt-1 block w-full border rounded-md p-2" required>
                    @error('weight') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Deadline</label>
                    <input wire:model="deadline" type="date" class="mt-1 block w-full border rounded-md p-2" min="{{ now()->toDateString() }}">
                    @error('deadline') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-2">
                <button type="button" wire:click="closeModal" class="btn btn-secondary">
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endif

<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('score-updated', () => {
            alert('Score updated successfully!');
        });
    });
</script>

</div>
