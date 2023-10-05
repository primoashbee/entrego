<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    const APPLICANT = 'APPLICANT';
    const ADMINSTRATOR = 'ADMINISTRATOR';
    const SUB_HR = 'SUB_HR';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFullNameAttribute() :string 
    {
        if($this->role == User::ADMINSTRATOR){
            return "ADMINISTRATOR";
        }
        if(!$this->has_finished_profile){
            return $this->email;
        }
        return "{$this->first_name} {$this->last_name}";
    }

    public static function hasAdminUser() : bool
    {
        return self::where('role', self::ADMINSTRATOR)->count() > 0;
    }
}
