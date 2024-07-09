<div class="md:p-6 p-1 bg-white border-b border-gray-200 m-1">

<div class="align-middle inline-block min-w-full shadow overflow-x-auto bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
    <table class="min-w-full">
        <thead>
            <tr>
                
                <th class="px-2 md:px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Cultural Metric</th>
                <th class="px-2 md:px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Weight</th>
                <th class="px-2 md:px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Score</th>
                {{-- <th></th> --}}
            </tr>
        </thead>
        <tbody class="bg-white">
            {{-- @foreach ($data as $item) --}}
            <tr class="">
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">Integrity</td>
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">6</td>
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{$data->integrity}}</td>
            </tr>
            <tr class="">
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">Equity</td>
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">6</td>
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{$data->equity}}</td>
            </tr>
            <tr class="">
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">People</td>
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">6</td>
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{$data->people}}</td>
            </tr>
            <tr class="">
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">Excellence</td>
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">6</td>
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{$data->excellence}}</td>
            </tr>
            <tr class="">
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">Teamwork</td>
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">6</td>
                <td class="px-2 md:px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{$data->teamwork}}</td>
            </tr>
            {{-- @endforeach --}}
        </tbody>
    </table>

    <div class="md:m-2 m-1 flex justify-end ">
        <button class="md:px-5 px-2 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none", type="button", onclick="location.href = '{{ route('culture.show', 'we') }}'">View Details</button>
                    {{-- onclick="location.href = '{{ route('tasks.show', $data[$i]) }}'" --}}
                
    </div>

</div>

