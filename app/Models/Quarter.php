<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quarter extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function culture()
    {
        return $this->hasMany(Culture::class);
    }

    public function people()
    {
        return $this->hasMany(People::class);
    }
    public function equity()
    {
        return $this->hasMany(Equity::class);
    }
    public function integrity()
    {
        return $this->hasMany(Integrity::class);
    }
    public function teamwork()
    {
        return $this->hasMany(Teamwork::class);
    }
    public function excellence()
    {
        return $this->hasMany(Excellence::class);
    }

}
