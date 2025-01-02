<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("KPI Report for $quarter->name") }}
            </h2>
            <div class="h-10" >
                <a href="#">
                    {{-- {{ route('reports.download', $quarter->id) }}"> --}}
                    <x-secondary-button>
                        {{ __('Download Report') }}
                    </x-secondary-button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="m-10">
                    <div>
                        <div class="mt-4 mb-2"><h2>Culture Performance</h2></div>
                        <div class="align-middle inline-block min-w-full px-8 pt-3 mt-4">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Cultural Metric</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Weight</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Score</th>
                                        
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                            
                                    <tr class="">
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">Integrity</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">6</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">{{$culture->integrity}}</td>
                
                                    </tr>
                                    <tr class="">
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">Equity</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">6</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">{{$culture->equity}}</td>
                
                                    </tr>
                                    <tr class="">
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">People</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">6</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">{{$culture->people}}</td>
                
                                    </tr>
                                    <tr class="">
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">Excellence</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">6</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">{{$culture->excellence}}</td>
                                    </tr>
                                    <tr class="">
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">Teamwork</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">6</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">{{$culture->teamwork}}</td>
                    
                                    </tr>
                                    <tr></tr>
                                    <tr class="border-t-2 border-gray-300">
                                        <td class="col-span-2 px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">Total</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5"></td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">
                                            <div class="w-1/2 flex justify-center px-5 py-2 text-blue-500"><h3>{{$culture_score}}</h3></div>
                                        </td>
                                
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>            
                    </div>
                    <div>
                        <div class="mt-4 mb-2"><h2>Competency Performance</h2></div>
                        <div class="align-middle inline-block min-w-full px-8 pt-3 mt-4">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Competency Metric</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Weight</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Score</th>
                        
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($tasks as $task)
                                    <tr class="">
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">{{$task->title}}</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">{{$task->weight}}</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">{{$task->score}}</td>
                                            {{-- {{$data->integrity}}</td> --}}
                                    </tr>
                                    @endforeach
                                    <tr class="border-t-2 border-gray-300 mt-4">
                                        <td class="col-span-2 px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">Total</td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5"></td>
                                        <td class="px-6 py-2 whitespace-no-wrap text-blue-900 border-gray-500 text-sm leading-5">
                                            <div class="w-1/2 flex justify-center px-5 py-2 text-blue-500"><h2>{{$competence_score}}</h2></div>
                                        </td>
                                            {{-- {{$data->teamwork}}</td> --}}
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>            
                    </div>
                    <div class="w-full flex justify-content-end border-t-2 mt-2 border-blue-500">
                        <div class="w-1/4 flex justify-center px-5 py-2 border-blue-500 border text-blue-500 rounded mt-2">
                            <h1>
                                Overall: {{$overall_score}}%
                            </h1>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</x-app-layout>

