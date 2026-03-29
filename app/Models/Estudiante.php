<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Promocion;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'promocion_id',
        'nombre_completo',
        'quien_invito',
        'relacion_con_quien_invito',
        'evangelista_encargada',
        'edad',
        'fecha_nacimiento',
        'nacionalidad',
        'email',
        'telefono',
        'conoce_estudiantes',
        'translations',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'translations'     => 'array',
    ];

    /**
     * Devuelve un campo traducido al idioma activo, o el original si no hay traducción.
     */
    public function translated(string $field): ?string
    {
        $locale = app()->getLocale();

        if ($locale !== 'es' && isset($this->translations[$locale][$field])) {
            return $this->translations[$locale][$field];
        }

        return $this->$field;
    }

    // Relación con promoción
    public function promocion()
    {
        return $this->belongsTo(Promocion::class);
    }
}