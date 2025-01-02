<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <div class="flex justify-end w-full">
        {{-- <h1 class="mt-8 text-2xl font-medium text-gray-900 mb-5">
            Departments
        </h1> --}}
        <div class="h-10" >
            <x-secondary-button data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                {{ __('Add Department') }}
            </x-secondary-button>
        </div>
        
    </div>
    @if (count($data)>0)
    <div class="flex justify-between inline-block min-w-full bg-white shadow-dashboard px-8 pt-3 rounded-bl-lg rounded-br-lg">
        {{-- sm:items-start sm:justify-between flex-col --}}
        <div class="sm:flex-1 sm:flex mt-2 mb-4 work-sans flex flex-wrap"> 
            @foreach ($data as $department )
            
            <div class="mt-1 p-2 w-fit p-2 lg:mt-0 lg:flex-shrink-0">
                <div class="rounded-2xl bg-gray-50 py-6 text-center ring-1 ring-inset ring-gray-900/5 lg:flex lg:flex-col lg:justify-center lg:py-10">
                    <div class="mx-auto max-w-xs px-6">
                        {{-- <p class="text-base font-semibold text-gray-600"></p> --}}
                        <p class="mt-4 flex flex-wrap items-baseline justify-center gap-x-2">
                            <span class="text-l font-bold tracking-tight text-gray-900">{{$department->department_name}}</span>
                            {{-- <span class="text-sm font-semibold leading-6 tracking-wide text-gray-600">USD</span> --}}
                        </p>
                        <a type="button" onclick="location.href = '{{ route('department.show', $department->department_id) }}'" class="mt-8 block w-full rounded-md bg-indigo-600 px-2 py-1 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View More</a>
                        {{-- <p class="mt-6 text-xs leading-5 text-gray-600">Supervisor: {{}}</p> --}}
                    </div>
                </div>
            </div>

            @endforeach
        </div>
        
    </div>
</div>
    @else
        <div class="flex w-full justify-center py-12">
            <h1 class="text-blue-600 hover:underline">
                Nothing to show here
            </h1>
        </div> 
    @endif
        
    <!-- New Department Modal -->
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('department.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addDepartmentModalLabel">New Department</h1>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" placeholder="Department name" class="mb-2 block text-sm py-3 px-4 rounded-lg w-full border outline-purple-500" required />
                        <select id="supervisor_id" name="supervisor_id" class="mt-2 block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                            <option value="" disabled selected>Superviser</option>
                            @foreach ($users as $user )
                            <option value= {{$user->id}}> {{$user->first_name}} {{$user->last_name}} </option>
                            @endforeach
                            
                        </select>
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
