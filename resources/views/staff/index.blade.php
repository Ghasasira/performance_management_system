<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('staff.store') }}">
            @csrf

            <div class="mt-3">
                <x-label for="department" value="{{ __('Department') }}" />
                {{-- <x-input id="department" class="block mt-1 w-full" type="text" name="department" :value="old('sub_department')" required autofocus autocomplete="name" /> --}}

                <select id="department" name="department" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    <option value="" disabled selected>Department</option>
                    @foreach ($depts as $department )
                    <option value= {{$department->id}}>{{$department->name}}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mt-3">
                <x-label for="sub_department" value="{{ __('Sub Department') }}" />
                <select id="subdepartment" name="subdepartment" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    <option value="" disabled selected>Sub Department</option>
                    @foreach ($subdepts as $subdepartment )
                    <option value= {{$subdepartment->id}}>{{$subdepartment->name}}</option>
                    @endforeach
                </select>
                {{-- <x-input id="sub_department" class="block mt-1 w-full" type="text" name="sub_department" :value="old('sub_department')" required autofocus autocomplete="name" /> --}}
            </div>
            <div class="mt-3">
                <x-label for="role" value="{{ __('Role') }}" />
                <x-input id="role" class="block mt-1 w-full" type="text" name="role" :value="old('first_name')" required autofocus autocomplete="name" />
            </div>
            <div>
                {{-- class="flex justify-content-end w-full" --}}
                <x-button class="mt-2">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
