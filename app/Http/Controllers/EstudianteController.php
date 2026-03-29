<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Promocion;
use App\Exports\EstudiantesExport;
use App\Services\DeepLService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class EstudianteController extends Controller
{
    // Guardar nuevo estudiante
    public function store(Request $request, Promocion $promocion)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'quien_invito' => 'nullable|string|max:255',
            'relacion_con_quien_invito' => 'nullable|string|max:255',
            'evangelista_encargada' => 'nullable|string|max:255',
            'edad' => 'nullable|integer|min:0|max:150',
            'fecha_nacimiento' => 'nullable|date',
            'nacionalidad' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:255',
            'conoce_estudiantes' => 'nullable|string',
        ]);

        $validated['promocion_id'] = $promocion->id;

        // Traducir con DeepL
        $deepl = new DeepLService();
        if ($deepl->isConfigured()) {
            $validated['translations'] = $deepl->translateEstudiante($validated);
        }

        Estudiante::create($validated);

        return redirect()->route('promociones.show', $promocion)
            ->with('success', 'Estudiante agregado exitosamente');
    }

    // Actualizar estudiante
    public function update(Request $request, Promocion $promocion, Estudiante $estudiante)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'quien_invito' => 'nullable|string|max:255',
            'relacion_con_quien_invito' => 'nullable|string|max:255',
            'evangelista_encargada' => 'nullable|string|max:255',
            'edad' => 'nullable|integer|min:0|max:150',
            'fecha_nacimiento' => 'nullable|date',
            'nacionalidad' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:255',
            'conoce_estudiantes' => 'nullable|string',
        ]);

        // Re-traducir con DeepL si cambió algún campo traducible
        $deepl = new DeepLService();
        if ($deepl->isConfigured()) {
            $validated['translations'] = $deepl->translateEstudiante($validated);
        }

        $estudiante->update($validated);

        return redirect()->route('promociones.show', $promocion)
            ->with('success', 'Estudiante actualizado exitosamente');
    }

    // Eliminar estudiante
    public function destroy(Promocion $promocion, Estudiante $estudiante)
    {
        $estudiante->delete();

        return redirect()->route('promociones.show', $promocion)
            ->with('success', 'Estudiante eliminado exitosamente');
    }


    // Importar estudiantes desde CSV
public function importarCsv(Request $request, $promocionId)
{
    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt|max:2048',
    ]);

    $promocion = Promocion::findOrFail($promocionId);
    $file = $request->file('csv_file');
    
    // Leer el archivo CSV
    $csvData = array_map('str_getcsv', file($file->getRealPath()));
    $header = array_shift($csvData); // Primera fila como encabezados
    
    $importados = 0;
    $errores = [];

    foreach ($csvData as $index => $row) {
        // Saltar filas vacías
        if (empty(array_filter($row))) continue;

        try {
            Estudiante::create([
                'promocion_id' => $promocion->id,
                'nombre_completo' => $row[0] ?? null,
                'quien_invito' => $row[1] ?? null,
                'relacion_con_quien_invito' => $row[2] ?? null,
                'evangelista_encargada' => $row[3] ?? null,
                'edad' => !empty($row[4]) ? (int)$row[4] : null,
                'fecha_nacimiento' => !empty($row[5]) ? $row[5] : null,
                'nacionalidad' => $row[6] ?? null,
                'email' => $row[7] ?? null,
                'telefono' => $row[8] ?? null,
                'conoce_estudiantes' => $row[9] ?? null,
            ]);
            $importados++;
        } catch (\Exception $e) {
            $errores[] = "Fila " . ($index + 2) . ": " . $e->getMessage();
        }
    }

    if (count($errores) > 0) {
        return redirect()->route('promociones.show', $promocion)
            ->with('success', "Se importaron $importados estudiantes. Errores: " . implode(', ', $errores));
    }

    return redirect()->route('promociones.show', $promocion)
        ->with('success', "Se importaron $importados estudiantes exitosamente");
}

    // Exportar estudiantes a Excel (.xlsx real)
    public function exportarExcel(Promocion $promocion)
    {
        $nombre = 'Promocion_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $promocion->nombre) . '_' . date('Y-m-d') . '.xlsx';
        return Excel::download(new EstudiantesExport($promocion), $nombre);
    }

}
