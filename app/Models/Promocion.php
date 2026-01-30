<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    use HasFactory;

    protected $table = 'promociones';
    protected $primaryKey = 'id';  // ← AGREGAR ESTA LÍNEA
    public $incrementing = true;   // ← AGREGAR ESTA LÍNEA

    protected $fillable = [
        'nombre',
        'año',
        'activa',
        'descripcion',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    // Relación con estudiantes
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }

    // Contar estudiantes
    public function getTotalEstudiantesAttribute()
    {
        return $this->estudiantes()->count();
    }
}