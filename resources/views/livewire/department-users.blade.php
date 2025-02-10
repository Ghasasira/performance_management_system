<div class="flex">
    <!-- Sidebar -->
    <div class="w-1/4 bg-white p-4 h-[80vh] overflow-y-auto">
        <h2 class="text-lg font-bold mb-2">Department Members</h2>
        <ul>
            @foreach($users as $user)
                <li class="cursor-pointer p-2 {{ $selectedUserId == $user->userId ? 'bg-blue-500 text-white' : '' }}"
                    wire:click="showUserTasks({{ $user->userId }})"
                    >
                    {{-- <button wire:click="showUserTasks({{ $user->userId }})" class="w-full"> --}}
                    {{ strtoupper($user->firstName) }} {{ strtoupper($user->lastName) }}
                {{-- </button> --}}
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Main Body -->
    <div class="w-3/4 p-4 h-[80vh] overflow-y-auto">
        <h2 class="text-lg font-bold mb-2">Tasks</h2>
        @if($selectedUserId)
            <ul>
                @forelse($tasks as $task)
                <div class="bg-white shadow-lg rounded-md p-4 hover:bg-gradient-to-r hover:from-red-50 hover:to-sky-50 m-2">
                    <h1 class="font-bold text-xl pb-4">{{ $task->title }}</h1>
                    <p >
                        {{ $task->description }}
                    </p>
                </div>
                    {{-- <li class="p-2 border-b">{{ $task->title }}</li> --}}
                @empty
                    <p class="text-gray-500">No tasks found for this user.</p>
                @endforelse
            </ul>
        @else
            <p class="text-gray-500">Select a user to view tasks.</p>
        @endif
    </div>
</div>
