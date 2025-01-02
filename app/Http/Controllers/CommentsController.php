<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;


class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($taskId)
    {

        // $task = Task::with('comments')->find($taskId);
        // $result = Comment::where('status', "not open")->first();

        // dd($result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // You can implement this to show a form for creating a new comment if needed
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $taskId)
    {
        // Validate the request data
        $request->validate([
            'task_id' => 'required|integer',
            'subject' => 'required|string|max:255',
            'comment' => 'required|string',
            'from' => 'required|string|max:255',
        ]);

        $task = Task::find($taskId);

        try {
            // Create a new comment with default status 'not read'
            $task->comments()->create([
                // "id" => "123",
                'task_id' => $request->task_id,
                'status' => 'not read',
                'subject' => $request->subject,
                'comment' => $request->comment,
                'sender' => $request->from,
            ]);

            // dd("here");

            // Optionally, return a response
            smilify('success', 'Comment uploaded successfully.');
            return back();
        } catch (\Exception $e) {
            smilify('error', 'An error occurred while commenting.');
            dd($e);
            return back();
        }
        // return;
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        // Update the comment status to 'read'
        $comment->update(['status' => 'read']);

        // Return the comment
        return response()->json($comment);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        // You can implement this to show a form for editing a comment if needed
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'heading' => 'required|string|max:255',
            'comment' => 'required|string',
            'from' => 'required|string|max:255',
        ]);

        // Update the comment with the validated data
        $comment->update($validatedData);

        // Optionally, return a response
        return response()->json(['message' => 'Comment updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        // Delete the comment
        $comment->delete();

        // Optionally, return a response
        return response()->json(['message' => 'Comment deleted successfully!']);
    }
}
