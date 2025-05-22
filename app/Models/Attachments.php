<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;
    protected $table = 'attachments';
    protected $fillable = [
        'link',
        'task_id',
        'file_name',
        'description',
    ];

    public function task()
    {
        return $this->belongsTo('App\Models\Task');
    }
}
