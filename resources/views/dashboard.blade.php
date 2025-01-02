<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-content-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="h-10" >
                <x-secondary-button data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                    {{ __('Get Report') }}
                </x-secondary-button>

                <!-- Report Modal -->
                        <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('reports.show') }}" method="POST">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="addDepartmentModalLabel">Get Report</h1>
                                        </div>
                                        <div class="modal-body">
                                            {{-- <input type="text" name="name" placeholder="Department name" class="mb-2 block text-sm py-3 px-4 rounded-lg w-full border outline-purple-500" required /> --}}
                                            <select id="quarter_id" name="quarter_id" class="mt-2 block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                                <option value="" disabled selected>Quarter</option>
                                                @if ($data)
                                                @foreach ($data as $quarter )
                                                <option value= {{$quarter->id}}> {{$quarter->name}} </option>
                                                @endforeach 
                                                @else
                                                {{-- <option value= {{$quarter-> {{$quarter->name}} </option>  --}}
                                                @endif                                                
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Get</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <x-welcome />
            </div>
        </div>
    </div>
</x-app-layout>
