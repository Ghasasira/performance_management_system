<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'supervisor_id',
    ];

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function subdepartments()
    {
        return $this->hasMany(Subdepartment::class,'dept_id');
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
    
}
