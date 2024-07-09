
{{-- <x-authentication-card> --}}
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf    
        <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
            <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
                <div class="max-w-md mx-auto">
                <div class="flex items-center space-x-5">
                    <div class="h-14 w-14 bg-yellow-200 rounded-full flex flex-shrink-0 justify-center items-center text-yellow-500 text-2xl font-mono">i</div>
                    <div class="block pl-2 font-semibold text-xl self-start text-gray-700">
                    <h2 class="leading-relaxed">Create A Task</h2>
                    <p class="text-sm text-gray-500 font-normal leading-relaxed">Please ensure you've clearly discussed this task with your supervisee.</p>
                    </div>
                </div>
                <div class="divide-y divide-gray-200">
                    <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                    <div class="flex flex-col">
                        <label class="leading-loose">Task Title</label>
                        <input id="title" name="title" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="Task title">
                    </div>
                    <div class="flex flex-col">
                        <label class="leading-loose">Event Description</label>
                        <textarea id="description" name="description" rows="4" type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="Description"></textarea>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="flex flex-col">
                        <label class="leading-loose">Task Weight</label>
                        <div class="relative focus-within:text-gray-600 text-gray-400">
                            <input id="weight" name="weight" type="numbers" class="pr-4 pl-10 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="10">
                            {{-- <div class="absolute left-3 top-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div> --}}
                        </div>
                        </div>
                        <div class="flex flex-col">
                        <label class="leading-loose">Deadline</label>
                        <input type="text" id="deadline" name="deadline" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="deadline">
                        {{-- <div id="deadline" name="deadline" class="relative focus-within:text-gray-600 text-gray-400">
                            <input type="date" class="pr-4 pl-10 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="26/02/2020">
                            <div class="absolute left-3 top-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        </div> --}}
                        </div>
                    </div>
                    {{-- <input  type="hidden" id="user_id" name="user_id" value="2" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600"> --}}
                    {{-- <div class="flex flex-col">
                        <label class="leading-loose">Event Description</label>
                        <input type="text" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="Optional">
                    </div> --}}
                    </div>
{{-- ........................ --}}
            <div class="w-full max-w-xs">
                <label for="dropdown" class="block text-sm font-medium text-gray-700 mb-1">Choose an option</label>
                <div class="relative">
                    <select id="user_id" name="user_id" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option value="" disabled selected>Supervisee</option>
                        @foreach ($data as $user )
                        <option value= {{$user->id}}>{{$user->first_name}} {{$user->last_name}}</option>
                        @endforeach
                        {{-- <option value="option1">Option 1</option>
                        <option value="option2">Option 2</option>
                        <option value="option3">Option 3</option> --}}
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                    </div>
                </div>
            </div>
{{-- ........................ --}}
                    <div class="pt-4 flex items-center space-x-4">
                        <button class="flex justify-center items-center w-full text-gray-900 px-4 py-3 rounded-md focus:outline-none" type="button" onclick="window.history.back();" >
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Cancel
                        </button>
                        <button class="bg-blue-500 flex justify-center items-center w-full text-white px-4 py-3 rounded-md focus:outline-none"  type="submit" >Create</button>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </form>
{{-- </x-authentication-card> --}}