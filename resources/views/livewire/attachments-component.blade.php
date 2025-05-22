<div>
    <!-- Header and Upload Button -->
    <div class="flex justify-between items-center mb-4 pl-2 pr-4">
        <h3 class="mt-3 mb-3 text-xl font-medium text-blue-500">Attachments</h3>
        <div class="my-3">
            <button wire:click="openUploadModal"
                class="hidden sm:block px-4 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Add Attachment
            </button>
            <button wire:click="openUploadModal"
                class="md:hidden px-2 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Add
            </button>
        </div>
    </div>

    <!-- Attachments List -->
    <div class="space-y-3">
        @forelse($attachments as $attachment)
        <div class="p-3 bg-white rounded-lg shadow">
            <!-- Mobile Layout (sm and below) -->
            <div class="sm:hidden">
                <!-- Title/Description Row -->
                <div class="flex items-center space-x-3 mb-2">
                    @if(Str::endsWith($attachment->file_name, ['.pdf']))
                        <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                    @else
                        @php
                            $filePath = storage_path('app/public/pdfs/' . $attachment->file_name);
                            $icon = 'fas fa-file text-gray-500'; // default icon
                            $color = 'text-gray-500';

                            try {
                                if (file_exists($filePath)) {
                                    if (Str::startsWith(File::mimeType($filePath), 'image/')) {
                                        $icon = 'fas fa-file-image';
                                        $color = 'text-blue-500';
                                    }
                                } else {
                                    $icon = 'fas fa-exclamation-triangle';
                                    $color = 'text-red-500';
                                }
                            } catch (Exception $e) {
                                $icon = 'fas fa-exclamation-triangle';
                                $color = 'text-red-500';
                            }
                        @endphp

                        <i class="{{ $icon }} {{ $color }} text-xl"></i>
                    @endif
                    <div class="min-w-0">
                        @if ($attachment->description != null)
                            <p class="text-sm font-medium truncate">{{ $attachment->description }}</p>
                        @else
                            <p class="text-sm font-medium truncate">{{ $attachment->file_name }}</p>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons Row -->
                <div class="flex justify-end space-x-2 border-t pt-2">
                    <a href="{{ route('attachments.show', $attachment)}}"
                    {{-- Storage::url($attachment->link) }}" --}}
                    target="_blank">
                    <button wire:click="viewAttachment({{ $attachment->id }})"
                            class="p-2 text-blue-600 hover:text-blue-800">
                        <i class="fas fa-eye"></i>
                    </button>
                    </a>
                    {{-- <button wire:click="downloadAttachment({{ $attachment->id }})"
                            class="p-2 text-green-600 hover:text-green-800">
                        <i class="fas fa-download"></i>
                    </button> --}}
                    <button
                    {{-- wire:click="deleteAttachment({{ $attachment->id }})" --}}
                            class="p-2 text-red-600 hover:text-red-800"
                            onclick="return confirm('Are you sure you want to delete this attachment?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>

            <!-- Desktop Layout (md and above) -->
            <div class="hidden sm:flex items-center justify-between">
                <div class="flex items-center space-x-3 min-w-0 flex-1">
                    @if(Str::endsWith($attachment->file_name, ['.pdf']))
                        <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                    @else
                        @php
                            $filePath = storage_path('app/public/pdfs/' . $attachment->file_name);
                            $icon = 'fas fa-file text-gray-500'; // default icon
                            $color = 'text-gray-500';

                            try {
                                if (file_exists($filePath)) {
                                    if (Str::startsWith(File::mimeType($filePath), 'image/')) {
                                        $icon = 'fas fa-file-image';
                                        $color = 'text-blue-500';
                                    }
                                } else {
                                    $icon = 'fas fa-exclamation-triangle';
                                    $color = 'text-red-500';
                                }
                            } catch (Exception $e) {
                                $icon = 'fas fa-exclamation-triangle';
                                $color = 'text-red-500';
                            }
                        @endphp

                        <i class="{{ $icon }} {{ $color }} text-xl"></i>
                    @endif
                    <div class="min-w-0">
                        @if ($attachment->description != null)
                            <p class="text-sm font-medium truncate">{{ $attachment->description }}</p>
                        @else
                            <p class="text-sm font-medium truncate">{{ $attachment->file_name }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('attachments.show', $attachment)}}"
                    {{-- Storage::url($attachment->link) }}" --}}
                    target="_blank">
                        <button
                         {{-- wire:click="viewAttachment({{ $attachment->id }})" --}}
                                class="p-2 text-blue-600 hover:text-blue-800">
                            <i class="fas fa-eye"></i>
                        </button>
                    </a>
                    {{-- <button wire:click="downloadAttachment({{ $attachment->id }})"
                            class="p-2 text-green-600 hover:text-green-800">
                        <i class="fas fa-download"></i>
                    </button> --}}
                    <button wire:click="deleteAttachment({{ $attachment->id }})"
                            class="p-2 text-red-600 hover:text-red-800"
                            onclick="return confirm('Are you sure you want to delete this attachment?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
            <div class="p-4 text-center text-gray-500 bg-white rounded-lg shadow">
                No attachments found. Upload your first file!
            </div>
        @endforelse
    </div>

    <!-- Upload Modal -->
    @if($showUploadModal)
        <div class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('showUploadModal', false)"></div>

            <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg sm:mx-auto">
                <div class="px-6 py-4">
                    <div class="flex items-start justify-between">
                        <h3 class="text-lg font-medium text-gray-900">
                            Upload Attachment
                        </h3>
                        <button wire:click="$set('showUploadModal', false)" class="text-gray-400 hover:text-gray-500">
                            &times;
                        </button>
                    </div>

                    <div class="mt-4">
                        <form wire:submit.prevent="store">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">File</label>
                                    <input type="file" wire:model="pdf" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100">
                                    @error('pdf') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                                    <input type="text" wire:model="description"
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="$set('showUploadModal', false)"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Cancel
                    </button>
                    <button wire:click="store" wire:target="store" wire:loading.attr="disabled"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 ml-2">
                            <span wire:loading.remove wire:target="pdf">
                                <i class="fas fa-upload mr-2"></i> Save
                            </span>
                            <span wire:loading wire:target="pdf">
                                <i class="fas fa-spinner fa-spin mr-2"></i> Uploading...
                            </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- View Modal -->
    {{-- @if($showViewModal)
        <div class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="$set('showViewModal', false)"></div>

            <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-4xl sm:mx-auto">
                <div class="px-6 py-4">
                    <div class="flex items-start justify-between">
                        <h3 class="text-lg font-medium text-gray-900 truncate max-w-md">
                            {{ $currentAttachment->file_name ?? '' }}
                        </h3>
                        <button wire:click="$set('showViewModal', false)" class="text-gray-400 hover:text-gray-500">
                            &times;
                        </button>
                    </div>

                    <div class="mt-4">
                        @if($currentAttachment)
                            @if(Str::endsWith($currentAttachment->file_name, ['.pdf']))
                                <iframe src="{{ Storage::url('public/pdfs/' . $currentAttachment->file_name) }}"
                                        class="w-full h-96" frameborder="0"></iframe>
                            @elseif(Str::startsWith(File::mimeType(storage_path('app/public/pdfs/' . $currentAttachment->file_name)), 'image/'))
                                <img src="{{ Storage::url('public/pdfs/' . $currentAttachment->file_name) }}"
                                     class="max-w-full max-h-96 mx-auto">
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <i class="fas fa-file text-5xl mb-4"></i>
                                    <p>Preview not available for this file type.</p>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="$set('showViewModal', false)"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Close
                    </button>
                    @if($currentAttachment)
                        <button wire:click="downloadAttachment({{ $currentAttachment->id }})"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 ml-2">
                            Download
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div> --}}
