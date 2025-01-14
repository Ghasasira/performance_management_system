<div class="grid grid-cols-1 md:grid-cols-2 md:gap-4">
    @foreach ($data as $metric => $attributesArray)
        <div class="col-span-1 m-2 align-middle inline-block min-w-full shadow overflow-x-auto bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
            <div class="w-full justify-center flex bg-blue-500 p-2">
                <h3 class="text-white font-bold">{{ ucfirst($metric) }}</h3>
            </div>
            <div class="">
                <table class="w-full">
                    <thead>
                        <tr>
                            {{-- <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">No.</th> --}}
                            <th class="px-2 md:px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Metric</th>
                            <th class="px-2 md:px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Score</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($attributesArray as $attributes)
                            @foreach ($attributes as $key => $value)
                                @if (!in_array($key, ['id', "quarter_id",'user_id', 'created_at', 'updated_at']))
                                <tr>
                                    {{-- <td class="px-6 py-4 border-b border-gray-300">
                                        <div class="text-sm leading-5 text-gray-800">{{ $loop->parent->iteration }}</div>
                                    </td> --}}
                                    <td class="px-2 md:px-6 py-1 border-b border-gray-300">
                                        <div class="text-sm text-blue-900">{{ ucfirst(str_replace('_', ' ', $key)) }}</div>
                                    </td>
                                    <td class="px-2 md:px-6 py-1 border-b border-gray-300">{{ ucfirst($value) }}/10</td>
                                </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>

