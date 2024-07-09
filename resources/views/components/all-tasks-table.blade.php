@if (count($data)>0)
<div class="align-middle inline-block min-w-full shadow overflow-hidden bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">

    {{-- <div class="relative w-full h-full flex items-center">
        <div @click="selected=!selected" class="w-full flex justify-center text-gray-400 cursor-pointer">
            <button>U no like me?</button>
        </div>
        <div @click="selected=!selected" class="w-full flex justify-center text-gray-400 cursor-pointer">
            <button>No choose me</button>
        </div>
    </div> --}}

    <table class="min-w-full">
        <thead>
            <tr>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">No.</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Task</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Timeline</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Weight</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Status</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Evaluation Score</th>
                <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Progress</th>
                <th class="px-6 py-3 border-b-2 border-gray-300"></th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @for($i=0; $i < count($data); $i++)
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                        <div class="flex items-center">
                            <div>
                                <div class="text-sm leading-5 text-gray-800">{{$i+1}}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                        <div class="text-sm leading-5 text-blue-900">{{$data[$i]->title}}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{$data[$i]->deadline}}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{$data[$i]->weight}}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                        <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                        <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                        <span class="relative text-xs">{{$data[$i]->status}}</span>
                    </span>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">{{$data[$i]->score}}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">
                        <div class="progress">
                            @php
                                $percentage = ($data[$i]->score / $data[$i]->weight) * 100;
                            @endphp
                            <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $data[$i]->score }}" aria-valuemin="0" aria-valuemax="{{ $data[$i]->score }}">
                                {{-- {{ $data[$i]->score }}% --}}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-500 text-sm leading-5">
                        <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none", type="button", onclick="location.href = '{{ route('tasks.show', $data[$i]) }}'">View Details</button>
                    </td>
                </tr>
                
            @endfor
        </tbody>
    </table>
    <div class="sm:flex-1 sm:flex sm:items-center sm:justify-between mt-4 work-sans">
        <div class="mt-4">
            {{$data->links()}}
        </div>
</div> 
@else
<div class="flex w-full justify-center py-12">
    <h1 class="text-blue-600 hover:underline">
        Nothing to show here
    </h1>
</div> 
@endif

        


{{-- </div> --}}
