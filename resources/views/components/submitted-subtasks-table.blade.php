<div class="m-2">
    @foreach ($data as $item )

    <div class="m-4">
        {{-- <span><h2>Task:</h2>  --}}
            <h2 class="font-bold">{{$item["task"]->title}}</h2>
        {{-- </span> --}}
    
    </div>

    <div class="align-middle inline-block min-w-full shadow mb-1 overflow-hidden bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
        <table class="min-w-full">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">No.</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Sub Task</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Weight</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Score</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Status</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300"></th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($item['subtasks'] as $index => $subtask)
                <tr class="mb-1">
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                        <div class="flex items-center">
                            <div>
                                <div class="text-sm leading-5 text-gray-800">#{{ $index + 1 }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                        <div class="text-sm leading-5 text-blue-900">{{ $subtask->title }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $subtask->weight }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-blue-900 text-sm leading-5">{{ $subtask->score }}</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">
                        <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                            <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                            <span class="relative text-xs">{{ $subtask->status }}</span>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-500 text-sm leading-5">
                        <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none">View Attachments</button>
                    </td>
                    <td>
                        <button class="approve-button middle none center mr-4 rounded-lg bg-green-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                data-bs-toggle="modal"
                                data-bs-target="#approveModal"
                                {{-- data-subtask-title="{{ $subtask->title }}"
                                data-subtask-id="{{ $subtask->id }}" --}}
                                >
                            Approve
                        </button>
                        <!-- Approve Modal -->
                        <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('tasks.subtasks.update', ["task" =>$item["task"]->id, 'id' => $subtask->id, 'subtask' => $subtask]) }}" method="POST" id="approveForm"> --}}
                                    @csrf
                                    @method('PATCH')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="approveModalLabel">Approve Submission</h1>
                                        </div>
                                        <div class="modal-body">
                                            <input type="number" name="score" placeholder="Score" class="block text-sm py-3 px-4 rounded-lg w-full border outline-purple-500" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Approve</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>  
                        
                    </td> 
                        
                        
                    
                </tr> 
                @endforeach
            </tbody>
        </table>
    </div>


    @endforeach
</div>