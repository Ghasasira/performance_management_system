<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <!-- Header Section -->
    <div class="flex justify-between items-center w-full mb-8">
        <h1 class="text-2xl font-bold text-gray-900">
            {{ $quarterName }}
        </h1>
        <x-secondary-button wire:click="openCreateModal" class="hidden sm:block">
            {{ __('Create New Task') }}
        </x-secondary-button>
    </div>

    <!-- Floating Action Button for Mobile -->
    <div class="fixed bottom-6 right-6 bg-blue-500 text-white p-4 rounded-full shadow-lg hover:bg-blue-600 transition-colors duration-300 block md:hidden">
        <button wire:click="openCreateModal" class="flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </button>
    </div>

    @if (count($data) > 0)
        <!-- Table for Larger Screens -->
        <div class="hidden md:block overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Task</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Timeline</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Weight</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Score</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @for ($i = 0; $i < count($data); $i++)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $i + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-900">{{ $data[$i]->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $data[$i]->deadline }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $data[$i]->weight }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $data[$i]->score }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold text-green-900 bg-green-200 rounded-full">
                                    {{ $data[$i]->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center space-x-4">
                                    <!-- View Button -->
                                    <button
                                        onclick="location.href = '{{ route('tasks.show', $data[$i]) }}'"
                                        class="text-gray-500 hover:text-blue-600 transition-colors duration-200"
                                        title="View"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="4" fill="currentColor" />
                                            <path fill="currentColor" d="M30.94 15.66A16.69 16.69 0 0 0 16 5A16.69 16.69 0 0 0 1.06 15.66a1 1 0 0 0 0 .68A16.69 16.69 0 0 0 16 27a16.69 16.69 0 0 0 14.94-10.66a1 1 0 0 0 0-.68M16 22.5a6.5 6.5 0 1 1 6.5-6.5a6.51 6.51 0 0 1-6.5 6.5" />
                                        </svg>
                                    </button>

                                    <!-- Edit Button -->
                                    @if (!$data[$i]->is_locked && strtolower($data[$i]->status) !== "approved")
                                        <button
                                            wire:click="openEditModal({{ $data[$i]->id }})"
                                            class="text-gray-500 hover:text-blue-600 transition-colors duration-200"
                                            title="Edit"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                <path d="M21.731 2.269a2.625 2.625 0 00-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 000-3.712zM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 00-1.32 2.214l-.8 2.685a.75.75 0 00.933.933l2.685-.8a5.25 5.25 0 002.214-1.32L19.513 8.2z" />
                                            </svg>
                                        </button>
                                    @endif

                                    <!-- Delete Button -->
                                    @if (!$data[$i]->is_locked && strtolower($data[$i]->status) !== "approved")
                                        <button
                                            wire:click="delete({{ $data[$i]->id }})"
                                            class="text-gray-500 hover:text-red-600 transition-colors duration-200"
                                            title="Delete"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-6 h-6">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <!-- Cards for Smaller Screens -->
        <div class="block md:hidden space-y-4">
            @foreach ($data as $item)
                <div class="border rounded-lg p-4 bg-white shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <a href="{{ route('tasks.show', $item) }}" class="block">
                        <div class="flex justify-between items-start">
                            <div class="text-lg font-semibold text-blue-600">{{ $item->title }}</div>
                            <span class="px-2 py-1 text-xs font-semibold text-green-900 bg-green-200 rounded-full">
                                {{ $item->status }}
                            </span>
                        </div>
                        <div class="mt-3 text-sm text-gray-700">
                            <p>{{ $item->description }}</p>
                            <div class="flex flex-wrap gap-4 mt-3">
                                <div><span class="font-medium">Weight:</span> {{ $item->weight }}</div>
                                <div><span class="font-medium">Deadline:</span> {{ $item->deadline }}</div>
                            </div>
                        </div>
                    </a>
                    <div class="mt-4 flex justify-end space-x-2">
                        @if (!$item->is_locked && strtolower($item->status) !== "approved")
                            <button
                                wire:click="openEditModal({{ $item->id }})"
                                class="text-gray-500 hover:text-blue-600 transition-colors duration-200"
                                title="Edit"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <button
                                wire:click="delete({{ $item->id }})"
                                class="text-gray-500 hover:text-red-600 transition-colors duration-200"
                                title="Delete"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $data->links() }}
        </div>
    @else
        <div class="text-center py-8">
            <h1 class="text-blue-600 text-lg font-medium">
                No tasks created for this quarter yet.
            </h1>
        </div>
    @endif

    <!-- Modal -->
    @if ($isModalOpen)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                <h2 class="text-xl font-bold mb-4">
                    {{ $isEditing ? 'Edit Task' : 'Create New Task' }}
                </h2>
                <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}">
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
                            {{ $isEditing ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>