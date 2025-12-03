<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Proyecto;
use App\Models\Tarea;
use App\Services\ArchivoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    protected $archivoService;
    
    public function __construct(ArchivoService $archivoService)
    {
        $this->archivoService = $archivoService;
    }
    
    public function destroy(Archivo $archivo)
    {
        // Verificar permisos según tipo de entidad
        if ($archivo->tipo_entidad === 'proyecto') {
            $proyecto = Proyecto::findOrFail($archivo->entidad_id);
            $this->authorize('update', $proyecto);
        } elseif ($archivo->tipo_entidad === 'tarea') {
            $tarea = Tarea::findOrFail($archivo->entidad_id);
            $this->authorize('update', $tarea);
        } else {
            abort(403);
        }
        
        $result = $this->archivoService->eliminarArchivo($archivo->id);
        
        if ($result['success']) {
            return redirect()->back()
                ->with('success', 'Archivo eliminado exitosamente');
        } else {
            return redirect()->back()
                ->with('error', 'Error al eliminar el archivo');
        }
    }
    
    public function download(Archivo $archivo)
    {
        // Verificar permisos según tipo de entidad
        if ($archivo->tipo_entidad === 'proyecto') {
            $proyecto = Proyecto::findOrFail($archivo->entidad_id);
            $this->authorize('view', $proyecto);
        } elseif ($archivo->tipo_entidad === 'tarea') {
            $tarea = Tarea::findOrFail($archivo->entidad_id);
            $this->authorize('view', $tarea);
        } else {
            abort(403);
        }
        
        if (!Storage::disk('public')->exists($archivo->ruta_archivo)) {
            return redirect()->back()
                ->with('error', 'El archivo no existe');
        }

        return Storage::disk('public')->download($archivo->ruta_archivo, $archivo->nombre);
    }
}