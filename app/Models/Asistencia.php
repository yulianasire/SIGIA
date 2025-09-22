<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;
    protected $primaryKey = 'asisId';
    protected $fillable = ['idEstudiantes', 'asisFecha', 'asisEstado', 'asisFalta', 'idInscripcion'];

    public function estudiante() {
        return $this->belongsTo(User::class, 'idEstudiante');
    }
    public function inscripcion(){
        return $this->belongsTo(Inscripcion::class, 'idInscripcion');
    }
}
