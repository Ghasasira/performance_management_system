<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = [
        'task_id',
        'status',
        'subject',
        'comment',
        'sender',
    ];



    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }
}
