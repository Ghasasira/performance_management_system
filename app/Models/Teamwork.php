<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teamwork extends Model
{
    use HasFactory;
    protected $table = 'teamwork';
    protected $fillable = [
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function quarter(){
        return $this->belongsTo(Quarter::class);
    }
}