<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Register;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles;

    const ADMIN = 1;
    const   MANAGER = 2;
    const   TEACHER = 3;
    const STUDENT = 4;

    const ROLES =  [
        self::ADMIN => 'Administrador',
        self::MANAGER => 'SubAdministrador',
        self::TEACHER => 'Docente',
        self::STUDENT => 'estudiantes',

    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function register()
    {
        return $this->hasOne(Register::class);
    }


}
