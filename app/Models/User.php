<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    use HasFactory, Notifiable;
    use HasApiTokens;
    use HasFactory, Notifiable;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;


    protected $primaryKey = 'userId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'username',
        'password',
        'job_id',
        "id_no",
        "department_id",
        "job_id",
        "group_id",
        "accountStatus",
        "address",
        "primaryTelephone",
        "secondaryTelephone",
        "secondaryEmail",
        "DOB",
        "classification_name",
        //'is_staff',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id', 'userId');
    }

    public function hasSubmittedTasks(): bool
    {
        // Assuming you have a `tasks` relationship and a `status` column in the tasks table
        return $this->tasks()->where('status', 'submitted')->exists();
    }

    public function culture()
    {
        return $this->hasMany(Culture::class, 'user_id', 'userId');
    }

    public function people()
    {
        return $this->hasMany(People::class, 'user_id', 'userId');
    }
    public function equity()
    {
        return $this->hasMany(Equity::class, 'user_id', 'userId');
    }
    public function excellence()
    {
        return $this->hasMany(Excellence::class, 'user_id', 'userId');
    }
    public function teamwork()
    {
        return $this->hasMany(Teamwork::class, 'user_id', 'userId');
    }
    public function integrity()
    {
        return $this->hasMany(Integrity::class, 'user_id', 'userId');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
