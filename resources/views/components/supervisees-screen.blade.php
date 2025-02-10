{{-- <div class="p-6 lg:p-8 bg-white border-b border-gray-200"> --}}
    {{-- <div class="flex justify-between w-full">
        <h1 class="mt-8 text-2xl font-medium text-gray-900 mb-5">
            Submissions
        </h1>

    </div> --}}
    <div class="hidden md:block align-middle inline-block min-w-full shadow overflow-x-auto bg-white shadow-dashboard md:px-8 pt-3 rounded-bl-lg rounded-br-lg">
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
                @for($i = 0; $i < count($data); $i++)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                            <div class="text-sm leading-5 text-gray-800">{{ $i + 1 }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                            <div class="text-sm leading-5 text-blue-900">{{ strtoupper($data[$i]->firstName) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ strtoupper($data[$i]->lastName) }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ strtoupper($data[$i]->job->job_name) }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                            <span class="relative inline-block px-2 py-1 font-semibold text-green-900 leading-tight">
                                {{-- <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span> --}}
                                {{-- <span class="relative text-xs">{{ $data[$i]->status }}</span> --}}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-500 text-sm leading-5">
                            <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none" type="button" onclick="location.href = '{{ route('supervisees.show', $data[$i]) }}'">View Submissions</button>
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

