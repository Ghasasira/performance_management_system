<!-- component -->

<section class="py-1 bg-blueGray-50">
<div class="w-full xl:w-full mb-12 xl:mb-0 px-4 mx-auto mt-4">
  <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded ">
    <div class="w-full rounded-t mb-0 px-4 py-3 border-0">
      <div class="flex justify-between items-center w-full">
        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
            <h1 class="font-semibold">{{$dept->name}}</h1>
            <h4 class="font-semibold text-base text-gray-700">Supervisor: {{ $dept->supervisor->first_name }} {{ $dept->supervisor->last_name }}</h4>
            {{-- <h3 class="font-semibold text-base text-blueGray-700">{{$dept->supervisor->first_name}}</h3> --}}
        </div>
        <div class="relative w-full px-4 max-w-full flex-grow flex text-right">
          <button class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" data-bs-toggle="modal" data-bs-target="#addSubdepartmentModal">New Sub Dept</button>
        </div>
      </div>
    </div>

    <div class="block w-full m-4 overflow-x-auto">

      @if (count($dept->subdepartments)>0)
        <table class="items-center bg-transparent w-full border-collapse ">
          <thead>
            <tr>
              <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">SubDepartment</th>
              <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Members</th>
              <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Supervisor</th>
              <th class="px-6 py-3 border-gray-300"></th>
              
            </tr>
          </thead>

          <tbody>
              @foreach ($dept->subdepartments as $subdept)
              <tr>
                  <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 ">
                    {{$subdept->name}}
                  </th>
                  <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 ">
                    20
                  </td>
                  <td class="border-t-0 px-6 align-center border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    {{$subdept->supervisor->first_name}} {{$subdept->supervisor->last_name}}
                  </td>
                  <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                    {{-- <i class="fas fa-arrow-up text-emerald-500 mr-4"></i> --}}
                    <div class="mt-1 mb-1">
                      <x-secondary-button data-bs-toggle="modal" data-bs-target="#editSubdepartmentModal">
                          {{ __('Edit') }}
                      </x-secondary-button>
                  </div>
                  </td>
                </tr>  
              @endforeach
          </tbody>

        </table>
      @else
      <div class="flex w-full justify-center py-12">
        <h1 class="text-blue-600 hover:underline">
            No Sub departments
        </h1>
    </div>
      @endif
      
    </div>
  </div>
</div>

<!-- New Subdepartment Modal -->
<div class="modal fade" id="addSubdepartmentModal" tabindex="-1" aria-labelledby="addSubdepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('department.subdepartment.store',$dept->id)}}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addDepartmentModalLabel">New Sub Department</h1>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" placeholder="Subdepartment name" class="block text-sm py-3 px-4 rounded-lg w-full border outline-purple-500" />
                    {{-- <input type="text" name="name" placeholder="Subdepartment name" class="block text-sm py-3 px-4 rounded-lg w-full border outline-purple-500" required /> --}}
                    <select id="supervisor_id" name="supervisor_id" class="mt-5 block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
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

</section>