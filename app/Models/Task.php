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

    ];

    // public function setUserIdAttribute($value)
    // {
    //     $this->attributes['user_id'] = auth()->id();
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'userId');
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachments::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
