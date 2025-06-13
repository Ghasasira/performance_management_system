<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integrity extends Model
{
    use HasFactory;
    protected $table = 'integrity';
    protected $fillable = [
        'user_id',
        'quarter_id'
    ];

    public function quarter()
    {
        return $this->belongsTo(Quarter::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'userId');
    }
}
