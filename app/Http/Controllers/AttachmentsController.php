<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Subtask;

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
            'pdf' => 'required|mimes:pdf|max:10000', // 10MB Max
            'subtaskId' => 'required',
            'subtask_title' => 'required|string',
        ]);

        try {
            $file = $request->file('pdf');
            $newTitle = str_replace(" ", "_", $request->subtask_title);
            $filename = $newTitle . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/pdfs', $filename);

            // Save file information to the database
            Attachments::create([
                'subtask_id' => $request->subtaskId,
                'file_name' => $filename,
                'link' => Storage::url($path),
            ]);
            smilify('success', 'PDF uploaded successfully.');
            return back();
        } catch (\Exception $e) {
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

        $file = file_get_contents($path);

        return Response::make($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $attachment->file_name . '"'
        ]);
        // dump($path);
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
    public function destroy(Attachments $attachments)
    {
        //
    }

    public function showSubtaskAttachments($subtaskId)
    {
        $subtask = Subtask::where('id', $subtaskId)->first();
        $attachments = $subtask->attachments()->get();
        return view('attachments.attachment-display', ["attachments" => $attachments, "subtask" => $subtask]);
    }
}
