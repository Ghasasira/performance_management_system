<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $table = 'tasks';
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'weight',
        'deadline',
        'is_locked',
        'is_admin_locked',

    ];

    // public function setUserIdAttribute($value)
    // {
    //     $this->attributes['user_id'] = auth()->id();
    // }

    protected $casts = [
        'is_locked' => 'boolean',
        'is_admin_locked' => 'boolean',
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
}
