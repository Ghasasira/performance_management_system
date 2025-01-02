<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;


    protected $primaryKey = 'job_id';


    protected $table = 'job';
    protected $fillable = [
        'department_id',
        'job_name',

    ];

    // public function setUserIdAttribute($value)
    // {
    //     $this->attributes['user_id'] = auth()->id();
    // }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
