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
        'subtask_id',
        'file_name',
    ];

    public function subtask()
    {
        return $this->belongsTo('App\Models\Subtask');
    }
}
