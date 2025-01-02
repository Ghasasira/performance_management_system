<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Submissions for Review') }}
            </h2>
            <button class="px-5 py-2 border-blue-500 border text-blue-500 rounded transition duration-300 hover:bg-blue-700 hover:text-white focus:outline-none", type="button", onclick="location.href = '{{ route('culture.assessment',$superviseeId) }}'">Culture Metrics</button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="">
                <x-submitted-subtasks-table :data="$data" :supervisee="$superviseeId"/>
            </div>
        </div>
    </div>
</x-app-layout>