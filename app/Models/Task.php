<?php

namespace App\Models;

use App\Traits\AuditLogging;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use AuditLogging;
    use HasFactory;
    protected $table = 'tasks';
    protected $fillable = [
        'user_id',
        'title',
        'quarter_id',
        'description',
        'weight',
        'deadline',
        'is_locked',
        'is_admin_locked',
        'is_approved',

    ];

    // public function setUserIdAttribute($value)
    // {
    //     $this->attributes['user_id'] = auth()->id();
    // }

    protected $casts = [
        'is_locked' => 'boolean',
        'is_admin_locked' => 'boolean',
        'is_approved' => 'boolean',
    ];

    // Methods to check lock status
    public function isUserLocked()
    {
        return $this->is_locked;
    }

    public function isAdminLocked()
    {
        return $this->is_admin_locked;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'userId');
    }


    public function attachments()
    {
        return $this->hasMany(Attachments::class);
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    // Define the relationship with the Quarter model
    public function quarter()
    {
        return $this->belongsTo(Quarter::class);
    }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    // ...............................................................................

    // Add logging to key methods
    public function approve($approver)
    {
        $this->is_approved = true;
        $this->is_admin_locked = true;
        $this->is_locked = true;
        if (strtolower($this->status) == "pending") {
            $this->status = "approved";
        }
        $this->save();

        $this->logTaskAction('task_approved', 'Task approved by admin', [
            'approver_id' => $approver->userId,
            'previous_status' => $this->getOriginal('status')
        ]);

        return $this;
    }

    public function hasUnreadComments(): bool
    {
        return $this->comments()->where('status', 'unread')->exists();
    }

    public function defer()
    {
        $originalStatus = $this->status;
        $this->status = 'deferred';
        $this->save();

        $this->logTaskAction('task_deferred', 'Task deferred', [
            'previous_status' => $originalStatus
        ]);

        return $this;
    }

    public function scoreTask($score)
    {
        $originalScore = $this->score;
        $this->score = $score;
        $this->status = 'graded';
        $this->save();

        $this->logTaskAction('task_scored', 'Task scored', [
            'previous_score' => $originalScore,
            'new_score' => $score
        ]);

        return $this;
    }

    //   ...............................

    public function editTask(array $updates)
    {
        //   dd("updates");
        // Store original values for comparison
        $originalAttributes = $this->getOriginal();

        // Prepare metadata of changes
        $changedAttributes = [];
        foreach ($updates as $key => $value) {
            if ($this->$key != $value) {
                $changedAttributes[$key] = [
                    'old' => $this->$key,
                    'new' => $value
                ];
            }
        }

        //   dd($updates);
        // Update the task
        $this->fill($updates);
        $this->save();

        // Log the edit action
        $this->logTaskAction('task_edited', 'Task details updated', [
            'changed_attributes' => $changedAttributes,
            'editor_id' => auth()->id()
        ]);

        return $this;
    }

    public function submitTask()
    {
        $originalStatus = $this->status;

        $this->status = 'submitted';
        $this->save();

        $this->logTaskAction('task_submitted', 'Task submitted for review', [
            'previous_status' => $originalStatus
        ]);

        return $this;
    }

    public function deleteTask()
    {
        // Log details before deletion
        $taskDetails = $this->toArray();

        // Perform soft delete or hard delete based on your preference
        $this->logTaskAction('task_deleted', 'Task permanently deleted', [
            'deleted_task_details' => $taskDetails,
            'deleter_id' => auth()->user()->userId
        ]);

        // Actual deletion
        $this->subtasks()->delete();
        $this->delete();

        return true;
    }
}
