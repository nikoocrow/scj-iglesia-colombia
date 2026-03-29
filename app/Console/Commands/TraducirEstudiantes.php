<?php

namespace App\Console\Commands;

use App\Models\Estudiante;
use App\Services\DeepLService;
use Illuminate\Console\Command;

class TraducirEstudiantes extends Command
{
    protected $signature   = 'app:traducir-estudiantes';
    protected $description = 'Traduce los datos existentes de todos los estudiantes al coreano usando Google Translate';

    public function handle()
    {
        $estudiantes = Estudiante::all();
        $total       = $estudiantes->count();
        $deepl       = new DeepLService();

        $this->info("Traduciendo {$total} estudiantes...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($estudiantes as $estudiante) {
            try {
                $data = $estudiante->toArray();
                $translations = $deepl->translateEstudiante($data);
                $estudiante->update(['translations' => $translations]);
            } catch (\Exception $e) {
                $this->newLine();
                $this->warn("Error en estudiante ID {$estudiante->id}: " . $e->getMessage());
            }

            $bar->advance();

            // Pequeña pausa para no saturar la API
            usleep(300000); // 0.3 segundos entre cada estudiante
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✅ Traducción completada para {$total} estudiantes.");
    }
}
