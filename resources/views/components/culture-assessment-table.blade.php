<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <div class="align-middle inline-block min-w-full shadow overflow-hidden bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
    <table class="min-w-full">
        <thead>
            <tr>
                
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Cultural Metric</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Weight</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Score</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider"></th>
            </tr>
        </thead>
        <tbody class="bg-white">
            {{-- @foreach ($data as $item) --}}
            <tr class="">
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">Integrity</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">6</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{$data->integrity}}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                    <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none"
                     type="button" 
                     data-bs-toggle="modal"
                     data-bs-target="#integrityModal">
                        {{-- , onclick="location.href = '{{ route('culture.show', 'we') }}'" --}}
                        Edit
                    </button>

                </td>
            </tr>
            <tr class="">
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">Equity</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">6</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{$data->equity}}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                    <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none"
                     type="button" 
                     data-bs-toggle="modal"
                     data-bs-target="#equityModal">
                        {{-- , onclick="location.href = '{{ route('culture.show', 'we') }}'" --}}
                        Edit
                    </button>

                </td>
            </tr>
            <tr class="">
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">People</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">6</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{$data->people}}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                    <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none"
                     type="button" 
                     data-bs-toggle="modal"
                     data-bs-target="#peopleModal">
                        Edit
                    </button>

                </td>
            </tr>
            <tr class="">
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">Excellence</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">6</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{$data->excellence}}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                    <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none"
                     type="button" 
                     data-bs-toggle="modal"
                     data-bs-target="#excellenceModal">
                        {{-- , onclick="location.href = '{{ route('culture.show', 'we') }}'" --}}
                        Edit
                    </button>

                </td>
            </tr>
            <tr class="">
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">Teamwork</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">6</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{$data->teamwork}}</td>
                <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                    <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none"
                     type="button" 
                     data-bs-toggle="modal"
                     data-bs-target="#teamworkModal">
                        {{-- , onclick="location.href = '{{ route('culture.show', 'we') }}'" --}}
                        Edit
                    </button>

                </td>
            </tr>
        </tbody>
    </table>

    <!-- Edit Culture Modals -->
    <div class="modal fade" id="equityModal" tabindex="-1" aria-labelledby="equityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <x-equityform :superviseeId="$data->user_id" />
        </div>
    </div>

    <div class="modal fade" id="peopleModal" tabindex="-1" aria-labelledby="peopleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <x-peopleform  :superviseeId="$data->user_id" />
        </div>
    </div>  

    <div class="modal fade" id="excellenceModal" tabindex="-1" aria-labelledby="excellenceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <x-excellenceform :superviseeId="$data->user_id" />
        </div>
    </div>  

    <div class="modal fade" id="teamworkModal" tabindex="-1" aria-labelledby="teamworkModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <x-teamworkform :superviseeId="$data->user_id" />
        </div>
    </div>  
    <div class="modal fade" id="integrityModal" tabindex="-1" aria-labelledby="integrityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <x-integrityform :superviseeId="$data->user_id" />
        </div>
    </div>  
</div>

