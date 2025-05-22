<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full justify-between">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{-- {{ __(" --}}
                KPI Report for {{$data['department']}} for {{$data['quarter']}}
                {{--}}") }} --}}
            </h1>
            {{-- <div class="h-10" >
                <a href="route('reports.download', $quarter->id) }}">
                    <x-secondary-button>
                        {{ __('Download Report') }}
                    </x-secondary-button>
                </a>
            </div> --}}
        </div>
    </x-slot>



    <div class="py-12 px-10 bg-white">

        {{-- <section class="bg-white px-5 mx-3 rounded"> --}}
            {{-- <h4 class="text-xl">Average Score</h4> --}}
            <div class="flex flex-row items-center justify-content-around px-5 mx-3 w-full">
              <div
                class="flex justify-evenly items-center w-96 lg:w-1/3 p-3 m-3 border border-gray-300 rounded"
              >
              @if($data["svgs"]["culture"] == 'high')
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="text-green-400 w-20 h-20"
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"
                />
                </svg>
             @elseif($data["svgs"]["culture"] == 'medium')
             <svg
               xmlns="http://www.w3.org/2000/svg"
               fill="none"
               viewBox="0 0 24 24"
               stroke-width="1.5"
               stroke="currentColor"
               class="text-red-300 w-20 h-20"
             >
               <path
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"
               />
             </svg>
             @else
             <svg
               xmlns="http://www.w3.org/2000/svg"
               fill="none"
               viewBox="0 0 24 24"
               stroke-width="1.5"
               stroke="currentColor"
               class="text-red-300 w-20 h-20"
             >
               <path
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"
               />
             </svg>
             @endif

                <div class="text-center">
                  <h2 class="text-4xl font-bold pb-2">{{$data['average_department_culture_score']}}/30</h2>
                  <h4 class="inline text-gray-500 text-md">Avarage Culture Score</h4>
                </div>
              </div>
              <div
                class="flex justify-evenly items-center w-96 lg:w-1/3 p-3 m-3 border border-gray-300 rounded"
              >
              @if($data["svgs"]["performance"] == 'high')
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="text-green-400 w-20 h-20"
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"
                />
                </svg>
             @elseif($data["svgs"]["performance"] == 'medium')
             <svg
               xmlns="http://www.w3.org/2000/svg"
               fill="none"
               viewBox="0 0 24 24"
               stroke-width="1.5"
               stroke="currentColor"
               class="text-red-300 w-20 h-20"
             >
               <path
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"
               />
             </svg>
             @else
             <svg
               xmlns="http://www.w3.org/2000/svg"
               fill="none"
               viewBox="0 0 24 24"
               stroke-width="1.5"
               stroke="currentColor"
               class="text-red-300 w-20 h-20"
             >
               <path
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"
               />
             </svg>
             @endif
                <div class="text-center">
                  <h2 class="text-4xl font-bold pb-2">{{$data["average_department_performance_score"]}}/70</h2>
                  <h4 class="inline text-gray-500 text-md">Avarage Competance Score</h4>
                </div>
              </div>
              <div
                class="flex justify-evenly items-center w-96 lg:w-1/3 p-3 m-3 border border-gray-300 rounded"
              >
              @if($data["svgs"]["overall"] == 'high')
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="text-green-400 w-20 h-20"
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"
                />
                </svg>
             @elseif($data["svgs"]["overall"] == 'medium')
             <svg
               xmlns="http://www.w3.org/2000/svg"
               fill="none"
               viewBox="0 0 24 24"
               stroke-width="1.5"
               stroke="currentColor"
               class="text-red-300 w-20 h-20"
             >
               <path
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"
               />
             </svg>
             @else
             <svg
               xmlns="http://www.w3.org/2000/svg"
               fill="none"
               viewBox="0 0 24 24"
               stroke-width="1.5"
               stroke="currentColor"
               class="text-red-300 w-20 h-20"
             >
               <path
                 stroke-linecap="round"
                 stroke-linejoin="round"
                 d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"
               />
             </svg>
             @endif
                <div class="text-center">
                  <h2 class="text-4xl font-bold pb-2">{{$data["average_department_score"]}}%</h2>
                  <h4 class="inline text-gray-500 text-md">Average Overall Score</h4>
                </div>
              </div>
            </div>
          {{-- </section> --}}

        <div class="min-w-full p-4">
        <table id="reportTable" class="min-w-full ">
            <thead>
                <tr>
                    {{-- <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">No.</th> --}}
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">First Name</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Last Name</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Role</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Culture</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Performance</th>
                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 text-blue-500 tracking-wider">Total</th>
                    {{-- <th class="px-6 py-3 border-b-2 border-gray-300"></th> --}}
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($data["report"] as $reportdata )
                    <tr>

                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                            <div class="text-sm leading-5 text-blue-900">{{ $reportdata["firstname"]}}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-500">
                            <div class="text-sm leading-5 text-blue-900">{{ $reportdata["lastname"]}}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $reportdata["role"] }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $reportdata["cultureScore"] }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $reportdata["performanceScore"] }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b text-blue-900 border-gray-500 text-sm leading-5">{{ $reportdata["overallScore"] }}</td>

                        {{-- <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-500 text-sm leading-5">
                            <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none" type="button" onclick="location.href = '{{ route('supervisees.show',$reportdata['user']) }}'">View Submissions</button>
                        </td> --}}
                    </tr>
                @endforeach()

                {{-- @endfor --}}
            </tbody>
        </table>
    </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#reportTable').DataTable({
                paging: false,     // No pagination
                ordering: false,   // Disable column sorting
                info: false        // Hide table info
            });
        });
    </script>

</x-app-layout>

