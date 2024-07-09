<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cultural Performance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if ($data)
                <x-culture-table :data="$data"/>
                @else
                    <x-no-culture-data-page />
                @endif
                
            </div>
        </div>
    </div>
</x-app-layout>