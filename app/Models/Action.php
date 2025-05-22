<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Action extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'type',
        'description',
        'metadata',
        'ip_address'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class)->withTrashed();
    }

    public function markTaskAsDeleted()
    {
        $this->task_exists = false;
        $this->save();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Static method to log actions
    public static function log($type, $task, $description = null, $metadata = null)
    {
        return self::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'type' => $type,
            'description' => $description,
            'metadata' => $metadata,
            'ip_address' => request()->ip()
        ]);
    }
}
