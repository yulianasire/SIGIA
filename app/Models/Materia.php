<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materia extends Model
{
    protected $fillable = ['nombre', 
    'carrera_id'];

     public function carrera(): BelongsTo
 {
 return $this->belongsTo(Carrera::class);
 }

}
