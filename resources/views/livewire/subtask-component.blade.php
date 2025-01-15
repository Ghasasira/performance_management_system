<div class="w-full px-1">

    <div class="-my-4 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 pr-10 lg:px-8">
        <div class="flex justify-between w-full">
            <h3 class="mt-3 mb-3 text-2xl font-medium text-blue-500">SubTasks</h3>
            <div class="mt-3 mb-3">
                <x-secondary-button data-bs-toggle="modal" data-bs-target="#addSubTaskModal" class="hidden sm:block">
                    {{ __('Add New Subtask') }}
                </x-secondary-button>
            </div>
        </div>
    </div>



    <div class="container mx-auto p-1 w-full">
        <!-- Table for medium and larger screens -->
        <div class="">
            <div class="align-middle inline-block min-w-full shadow overflow-x-auto bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
                @if (count($subtasks) == 0)
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
                        @foreach ($subtasks as $index => $subtask)
                        <tr class="py-2">
                            <td class="px-4 whitespace-no-wrap">
                                <div class="text-sm leading-5 text-gray-800">{{ $index + 1 }}</div>
                            </td>
                            <td class="px-4">
                                <div class="text-sm text-blue-900">{{ $subtask["title"] }}</div>
                            </td>
                            <td class="whitespace-no-wrap">
                                <div class="inline-flex items-center">

                                    <label
                                        class="relative flex cursor-pointer items-center rounded-full p-3"
                                        for="checkbox-1"
                                        data-ripple-dark="true"
                                        >
                                        <input
                                            type="checkbox"
                                            class="before:content[''] peer relative h-5 w-5 cursor-pointer appearance-none rounded-md border border-blue-gray-200 transition-all before:absolute before:top-2/4 before:left-2/4 before:block before:h-12 before:w-12 before:-translate-y-2/4 before:-translate-x-2/4 before:rounded-full before:bg-blue-gray-500 before:opacity-0 before:transition-opacity checked:border-pink-500 checked:bg-pink-500 checked:before:bg-pink-500 hover:before:opacity-10"
                                            id="checkbox-1"
                                            {{-- @checked(strtoLower($subtask["status"]) === 'submitted') --}}
                                            {{ strtoLower($subtask["status"]) === 'submitted' ? 'checked' : '' }}
                                        />
                                    </label>

                                    <button wire:click="delete({{ $subtask['id'] }})" class="btn btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z"/></svg>
                                    </button>
                                    {{-- </div> --}}

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


{{-- new subtask modal --}}
    <div class="modal fade" id="addSubTaskModal" tabindex="-1" aria-labelledby="addSubTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('tasks.subtasks.store',$task_id) }}" method="POST">
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



</div>

