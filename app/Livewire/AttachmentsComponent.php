<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Attachments;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AttachmentsComponent extends Component
{
    use WithFileUploads;

    public $taskId;
    public $task;
    public $attachments = [];
    public $pdf;
    public $description;
    public $uploading = false;

    // Modals
    public $showUploadModal = false;
    public $showViewModal = false;
    public $currentAttachment;

    protected $listeners = ['refreshAttachments' => '$refresh'];

    public function mount($taskId)
    {
        $this->taskId = $taskId;
        $this->task = Task::findOrFail($taskId);
        $this->loadAttachments();
    }

    public function loadAttachments()
    {
        $this->attachments = $this->task->attachments()->get();
    }

    public function rules()
    {
        return [
            'pdf' => 'required|max:20480', // 10MB Max
            'description' => 'string',
        ];
    }

    public function openUploadModal()
    {
        $this->reset(['pdf', 'description']);
        $this->resetErrorBag();
        $this->showUploadModal = true;
    }

    public function store()
    {
        $this->uploading = true;
        $this->validate();

        try {
            $newTitle = Str::slug($this->task->title, '_');
            // $currentDate = now()->format('Y-m-d');
            $uniqueId = substr(md5(uniqid(mt_rand(), true)), 0, 8);
            $filename = $newTitle . '_' . $uniqueId . '_' . $this->pdf->getClientOriginalName();
            $path = $this->pdf->storeAs('public/pdfs', $filename);

            Attachments::create([
                'task_id' => $this->taskId,
                'file_name' => $filename,
                'link' => Storage::url($path),
                'description' => $this->description,
            ]);

            $this->showUploadModal = false;
            $this->loadAttachments();
            smilify('success', 'Attachment uploaded successfully!');
            // $this->emit('notify', ['type' => 'success', 'message' => 'Attachment uploaded successfully!']);
        } catch (\Exception $e) {
            // $this->emit('notify', ['type' => 'error', 'message' => 'Error uploading file: ' . $e->getMessage()]);
            smilify('error', 'Error uploading file!' . $e);
        } finally {
            $this->uploading = false;
        }
    }

    public function viewAttachment($attachmentId)
    {
        $this->currentAttachment = Attachments::findOrFail($attachmentId);
        $this->showViewModal = true;
    }

    public function downloadAttachment($attachmentId)
    {
        $attachment = Attachments::findOrFail($attachmentId);
        $path = storage_path("app/public/pdfs/" . $attachment->file_name);

        if (!File::exists($path)) {
            $this->emit('notify', ['type' => 'error', 'message' => 'File not found.']);
            return;
        }

        return response()->download($path, $attachment->file_name);
    }

    public function deleteAttachment($attachmentId)
    {
        $attachment = Attachments::findOrFail($attachmentId);
        $filePath = 'public/pdfs/' . $attachment->file_name;

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
            // $attachment->delete();
        }

        $attachment->delete();
        $this->loadAttachments();
        smilify('error', 'File not found, it may have already been deleted.');

        // $this->emit('notify', ['type' => 'success', 'message' => 'Attachment deleted successfully!']);
    }

    public function render()
    {
        return view('livewire.attachments-component');
    }
}
