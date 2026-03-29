<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Log;

class DeepLService
{
    // Campos del estudiante que se traducen automáticamente
    const TRANSLATABLE_FIELDS = [
        'nombre_completo',
        'relacion_con_quien_invito',
        'nacionalidad',
        'conoce_estudiantes',
        'quien_invito',
        'evangelista_encargada',
    ];

    /**
     * Traduce un texto de español a coreano.
     */
    public function translate(string $text, string $targetLang = 'ko'): ?string
    {
        if (empty(trim($text))) {
            return null;
        }

        try {
            $tr = new GoogleTranslate();
            $tr->setSource('es')->setTarget($targetLang);
            return $tr->translate($text);
        } catch (\Exception $e) {
            Log::warning('Google Translate error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Genera el array de traducciones para todos los campos de un estudiante.
     */
    public function translateEstudiante(array $data): array
    {
        $translations = ['ko' => []];

        foreach (self::TRANSLATABLE_FIELDS as $field) {
            if (!empty($data[$field])) {
                $translated = $this->translate($data[$field], 'ko');
                if ($translated) {
                    $translations['ko'][$field] = $translated;
                }
            }
        }

        return $translations;
    }

    public function isConfigured(): bool
    {
        return true; // No necesita API key
    }
}
