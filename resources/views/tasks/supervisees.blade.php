<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Supervisees') }}
            </h2>
            <div>
                <x-secondary-button data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
                    {{ __('Get Dept Report') }}
                </x-secondary-button>
                @if (strtolower(auth()->user()->job->job_name) == "group ceo" ||auth()->user()->userId == "807"||strtolower(auth()->user()->job->job_name) == "chief of staff"||strtolower(auth()->user()->job->job_name) == "head of human capital")
                    <x-secondary-button data-bs-toggle="modal" data-bs-target="#addMgtModal">
                        {{ __('Get Mgt Report') }}
                    </x-secondary-button>
                    <x-secondary-button data-bs-toggle="modal" data-bs-target="#addCompModal">
                        {{ __('Get Overall Report') }}
                    </x-secondary-button>
                @endif
            </div>

            <!-- Report Modals -->
            <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('deptreports.show') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addDepartmentModalLabel">Get Departmental Report</h1>
                            </div>
                            <div class="modal-body">
                                <select id="quarter_id" name="quarter_id" class="mt-2 block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="" disabled selected>Quarter</option>
                                    @if ($quarters)
                                        @foreach ($quarters as $quarter)
                                            <option value="{{ $quarter->id }}">{{ $quarter->name }}</option>
                                        @endforeach
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

            <div class="modal fade" id="addMgtModal" tabindex="-1" aria-labelledby="addMgtModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('mgtreports.show') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addMgtModalLabel">Get Departmental Report</h1>
                            </div>
                            <div class="modal-body">
                                <select id="quarter_id" name="quarter_id" class="mt-2 block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="" disabled selected>Quarter</option>
                                    @if ($quarters)
                                        @foreach ($quarters as $quarter)
                                            <option value="{{ $quarter->id }}">{{ $quarter->name }}</option>
                                        @endforeach
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

            <div class="modal fade" id="addCompModal" tabindex="-1" aria-labelledby="addCompModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('compreports.show') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addCompModalLabel">Get Company Report</h1>
                            </div>
                            <div class="modal-body">
                                <select id="quarter_id" name="quarter_id" class="mt-2 block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                                    <option value="" disabled selected>Quarter</option>
                                    @if ($quarters)
                                        @foreach ($quarters as $quarter)
                                            <option value="{{ $quarter->id }}">{{ $quarter->name }}</option>
                                        @endforeach
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


    {{-- </div> --}}


    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {{-- <x-supervisees-screen :data="$data"/> --}}
                {{-- @livewire("supervisees") --}}
                @livewire('supervisees')
            </div>
        </div>
    </div>
</x-app-layout>
