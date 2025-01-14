<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Models\Task;

class AttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pdf' => 'required|max:10000', // 10MB Max
            'taskId' => 'required',
            'task_title' => 'required|string',
        ]);

        try {
            $file = $request->file('pdf');
            $newTitle = str_replace(" ", "_", $request->task_title);
            $filename = $newTitle . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/pdfs', $filename);

            // Save file information to the database
            Attachments::create([
                'task_id' => $request->taskId,
                'file_name' => $filename,
                'link' => Storage::url($path),
            ]);
            smilify('success', 'Attachment uploaded successfully.');
            return back();
        } catch (\Exception $e) {
            dd($e);
            smilify('error', 'An error occurred while uploading the file.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Attachments $attachment)
    {
        //function to show pdf in browser file without downloading it
        $path = storage_path("app/public/pdfs/" . $attachment->file_name);

        if (!file_exists($path)) {
            abort(404);
        }

        // ..................
        // $file = file_get_contents($path);

        // return Response::make($file, 200, [
        //     'Content-Type' => 'application/pdf',
        //     'Content-Disposition' => 'inline; filename="' . $attachment->file_name . '"'
        // ]);
        // ...................


        // Get the MIME type of the file
        $mimeType = File::mimeType($path);

        // Get the file content
        $file = file_get_contents($path);

        // Determine the Content-Disposition
        $disposition = (str_contains($mimeType, 'image') || str_contains($mimeType, 'pdf')) ? 'inline' : 'attachment';

        // Return the file as a response with proper headers
        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', $disposition . '; filename="' . $attachment->file_name . '"');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attachments $attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attachments $attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attachments $attachment)
    {
        // Get the relative path for deletion
        $filePath = 'public/pdfs/' . $attachment->file_name;

        // Check if the file exists in storage
        if (Storage::exists($filePath)) {
            // Delete the file from storage
            Storage::delete($filePath);
        } else {
            smilify('error', 'File not found, it may have already been deleted.');
            return back();
        }

        // Delete the attachment record from the database
        $attachment->delete();

        smilify('success', 'Attachment deleted successfully.');
        return back();
    }


    public function showTaskAttachments($taskId)
    {
        $task = Task::where('id', $taskId)->first();
        $attachments = $task->attachments()->get();
        return view('attachments.attachment-display', ["attachments" => $attachments, "task" => $task]);
    }
}
