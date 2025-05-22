<div class="hidden md:block align-middle inline-block min-w-full shadow overflow-x-auto bg-white shadow-dashboard md:px-8 pt-3 rounded-bl-lg rounded-br-lg">
    <!-- Search Input -->
    <div class="mb-4">
        <input wire:model.live="search" type="text" placeholder="Search supervisees... class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <table class="min-w-full">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">No.</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">First Name</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Last Name</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Job</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">New Submissions</th>
                <th class="px-6 py-3 border-b-2 border-gray-300"></th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @forelse($filteredSupervisees as $index => $supervisee)
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                        <div class="text-sm leading-5 text-gray-800">{{ $index + 1 }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                        <div class="text-sm leading-5 text-blue-900">{{ strtoupper($supervisee->firstName) }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ strtoupper($supervisee->lastName) }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ strtoupper($supervisee->job->job_name ?? 'N/A') }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                        <span class="relative inline-block px-2 py-1 font-semibold text-green-900 leading-tight">
                            {{-- Placeholder for new submissions --}}
                            @if ($supervisee->hasSubmittedTasks())
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 15 15">
                                <path fill="#1df507" d="M9.875 7.5a2.375 2.375 0 1 1-4.75 0a2.375 2.375 0 0 1 4.75 0"/>
                            </svg>
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-500 text-sm leading-5">
                        <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none" type="button" onclick="location.href = '{{ route('supervisees.show', $supervisee) }}'">View Submissions</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No supervisees found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $filteredSupervisees->links() }}
    </div>
</div>
