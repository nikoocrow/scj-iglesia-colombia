<?php

namespace App\Http\Controllers;

use App\Models\Promocion;
use Illuminate\Http\Request;

class PromocionController extends Controller
{
    // Listar todas las promociones
    public function index()
    {
        $promociones = Promocion::withCount('estudiantes')->orderBy('nombre', 'desc')->get();
        return view('promociones.index', compact('promociones'));
    }

    // Mostrar formulario de crear
    public function create()
    {
        return view('promociones.create');
    }

    // Guardar nueva promoción
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:promociones,nombre',
            'año' => 'nullable|integer|min:2000|max:2100',
            'descripcion' => 'nullable|string',
        ]);

        $validated['activa'] = true;

        Promocion::create($validated);

        return redirect()->route('promociones.index')
            ->with('success', 'Promoción creada exitosamente');
    }

    // Ver una promoción específica (con sus estudiantes)
    public function show($id)
    {
        $promocion = Promocion::findOrFail($id);
        $estudiantes = $promocion->estudiantes()->latest()->get();
        
        return view('promociones.show', compact('promocion', 'estudiantes'));
    }

    // Editar promoción
    public function edit($id)
    {
        $promocion = Promocion::findOrFail($id);
        return view('promociones.edit', compact('promocion'));
    }

    // Actualizar promoción
    public function update(Request $request, $id)
    {
        $promocion = Promocion::findOrFail($id);
        
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:promociones,nombre,' . $promocion->id,
            'año' => 'nullable|integer|min:2000|max:2100',
            'activa' => 'boolean',
            'descripcion' => 'nullable|string',
        ]);

        $promocion->update($validated);

        return redirect()->route('promociones.index')
            ->with('success', 'Promoción actualizada exitosamente');
    }

    // Eliminar promoción
    public function destroy($id)
    {
        $promocion = Promocion::findOrFail($id);
        $promocion->delete();

        return redirect()->route('promociones.index')
            ->with('success', 'Promoción eliminada exitosamente');
    }
}