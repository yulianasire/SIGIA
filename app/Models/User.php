<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

     protected $primaryKey = 'usId'; // asegúrate de que la PK sea correcta
    public $incrementing = true;
    protected $keyType = 'int';


    protected $fillable = [
        'usDocumento',
        'usMail',
        'usPassword',
        'usApellido',
        'usNombre',
        'usTelefono',
        'usDomicilio',
        'usProvincia',
        'usLocalidad',
    ];

    public function inscripciones(){
        return $this->hasMany(Inscripcion::class, 'idEstudiante');
    }
    public function asistencias(){
        return $this->hasMany(Asistencia::class, 'idEstudiante');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'usPassword',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getAuthPassword()
    {
        return $this->usPassword;
    }
}
