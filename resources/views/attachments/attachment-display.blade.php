<x-app-layout>
    <x-slot name="header">
        <div class="flex w-full justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __("$subtask->title Attachments") }}
            </h2>
            <div class="h-10">
                <x-secondary-button data-bs-toggle="modal" data-bs-target="#addAttachmentModal">
                    {{ __('Add attachment') }}
                </x-secondary-button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                @if($attachments->isEmpty())
                    <p>No attachments found.</p>
                @else
                    <div class="flex flex-col space-y-4">
                        @foreach ($attachments as $attachment)
                            <div class="flex items-center space-x-4">
                                <input
                                    type="text"
                                    value="{{ $attachment->file_name}}"
                                    class="h-full w-1/2 rounded-[7px] border border-blue-gray-200 bg-transparent px-3 py-2.5 pr-20 font-sans text-sm font-normal text-blue-gray-700 outline-none transition-all focus:border-2 focus:border-red-500 focus:outline-none"
                                    readonly
                                />
                                <a
                                    href="{{ route('attachments.show', $attachment)}}"
                                    {{-- Storage::url($attachment->link) }}" --}}
                                    target="_blank"
                                    class="rounded bg-green-500 py-2 px-4 text-center align-middle font-sans text-xs font-bold uppercase text-white transition-all hover:shadow-lg hover:bg-green-600 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85]"
                                >
                                    View
                                </a>
                                <form action="{{ route('attachments.destroy', $attachment) }}" method="POST" onsubmit="return confirm('Are You sure you want to delete attachment?');">
                                    {{-- <div name="trigger"> --}}
                                        @csrf
                                        @method('DELETE')
                                
                                    <button type="submit" class="text-white hover:bg-red-700 rounded h-10 w-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 flex items-center text-black mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                                
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- New Attachment Modal -->
        <div class="modal fade" id="addAttachmentModal" tabindex="-1" aria-labelledby="addAttachmentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('attachments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addAttachmentModalLabel">New Attachment</h1>
                        </div>
                        <div class="modal-body">
                            <input type="file" name="pdf" id="pdf" class="form-control shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <input type="hidden" name="subtaskId" value="{{ $subtask->id }}">
                            <input type="hidden" name="subtask_title" value="{{ $subtask->title }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
