<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;


    protected $primaryKey = 'department_id';

    protected $table = "department";

    protected $fillable = [
        'name',
    ];

    // public function supervisor()
    // {
    //     return $this->belongsTo(User::class, 'supervisor_id');
    // }

    // public function subdepartments()
    // {
    //     return $this->hasMany(Subdepartment::class, 'dept_id');
    // }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
