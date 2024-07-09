<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'subtasks';
    protected $fillable = [
        'title',
        'weight',
        'task_id',
    ];

    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }

    public function attachments()
    {
        return $this->hasMany(Attachments::class);
    }
}
