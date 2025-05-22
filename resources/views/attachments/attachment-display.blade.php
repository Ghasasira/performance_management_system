<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("$task->title Attachments") }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                @if($attachments->isEmpty())
                    <div class="text-center py-8">
                        <i class="fas fa-paperclip text-gray-400 text-4xl mb-2"></i>
                        <p class="text-gray-500">No attachments found for this task.</p>
                    </div>
                @else
                    <div class="space-y-4 divide-y divide-gray-200">
                        @foreach ($attachments as $attachment)
                            <div class="flex items-center justify-between py-4">
                                <div class="flex items-center space-x-4 min-w-0 flex-1">
                                    @php
                                        $fileIcon = 'fa-file';
                                        $fileColor = 'text-gray-500';

                                        // Determine file type and appropriate icon
                                        $extension = strtolower(pathinfo($attachment->file_name, PATHINFO_EXTENSION));

                                        $fileTypes = [
                                            'pdf' => ['icon' => 'fa-file-pdf', 'color' => 'text-red-500'],
                                            'doc' => ['icon' => 'fa-file-word', 'color' => 'text-blue-500'],
                                            'docx' => ['icon' => 'fa-file-word', 'color' => 'text-blue-500'],
                                            'xls' => ['icon' => 'fa-file-excel', 'color' => 'text-green-500'],
                                            'xlsx' => ['icon' => 'fa-file-excel', 'color' => 'text-green-500'],
                                            'jpg' => ['icon' => 'fa-file-image', 'color' => 'text-yellow-500'],
                                            'jpeg' => ['icon' => 'fa-file-image', 'color' => 'text-yellow-500'],
                                            'png' => ['icon' => 'fa-file-image', 'color' => 'text-yellow-500'],
                                            'gif' => ['icon' => 'fa-file-image', 'color' => 'text-yellow-500'],
                                            'zip' => ['icon' => 'fa-file-archive', 'color' => 'text-purple-500'],
                                            'rar' => ['icon' => 'fa-file-archive', 'color' => 'text-purple-500'],
                                        ];

                                        if (array_key_exists($extension, $fileTypes)) {
                                            $fileIcon = $fileTypes[$extension]['icon'];
                                            $fileColor = $fileTypes[$extension]['color'];
                                        }
                                    @endphp

                                    <i class="fas {{ $fileIcon }} {{ $fileColor }} text-2xl"></i>

                                    <div class="min-w-0">
                                        @if ($attachment->description)
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $attachment->description }}</p>
                                            <p class="text-xs text-gray-500 truncate">{{ $attachment->file_name }}</p>
                                        @else
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $attachment->file_name }}</p>
                                        @endif
                                        <p class="text-xs text-gray-400 mt-1">
                                            Uploaded {{ $attachment->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex space-x-2">
                                    <a href="{{ route('attachments.show', $attachment) }}"
                                       target="_blank"
                                       class="inline-flex items-center px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded-md transition-colors"
                                       title="View attachment">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>

                                    @can('delete', $attachment)
                                        <form action="{{ route('attachments.destroy', $attachment) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md transition-colors"
                                                    title="Delete attachment"
                                                    onclick="return confirm('Are you sure you want to delete this attachment?')">
                                                <i class="fas fa-trash-alt mr-1"></i> Delete
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- @if($attachments->hasPages()) --}}
                        {{-- <div class="mt-6">
                            {{ $attachments->links() }}
                        </div> --}}
                    {{-- @endif --}}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
