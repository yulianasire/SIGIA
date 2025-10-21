<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;
    protected $table = 'inscripciones';
    
    protected $primaryKey = 'insId';
    protected $fillable = ['idEstudiante', 'idMateria', 'insCicloLectivo', 'insEstado'];

    public function estudiante(){ return $this->belongsTo(User::class, 'idEstudiante'); 
    }

    public function materia(){ return $this->belongsTo(Materia::class, 'idMateria');
    }
}
