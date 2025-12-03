<?php

namespace App\Services;

use App\Models\Archivo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchivoService
{
    public function guardarArchivo($file, $tipoEntidad, $entidadId)
    {
        // Validar tipo de archivo
        $extension = strtolower($file->getClientOriginalExtension());
        $tiposPermitidos = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

        if (!in_array($extension, $tiposPermitidos)) {
            return [
                'success' => false,
                'message' => 'Tipo de archivo no permitido. Solo se permiten: PDF, DOC, DOCX, JPG, JPEG, PNG',
            ];
        }
        
        // Generar nombre único
        $nombreOriginal = $file->getClientOriginalName();
        $nombreUnico = Str::uuid() . '.' . $extension;
        
        // Definir ruta de almacenamiento
        $ruta = $tipoEntidad . '/' . $entidadId;
        
        // Guardar archivo en storage local
        $path = Storage::disk('public')->putFileAs($ruta, $file, $nombreUnico);

        if (!$path) {
            return [
                'success' => false,
                'message' => 'Error al subir el archivo',
            ];
        }
        
        // Crear registro en la base de datos
        $archivo = Archivo::create([
            'nombre' => $nombreOriginal,
            'ruta_archivo' => $path,
            'tipo_archivo' => $extension,
            'entidad_id' => $entidadId,
            'tipo_entidad' => $tipoEntidad,
        ]);
        
        return [
            'success' => true,
            'archivo' => $archivo,
        ];
    }
    
    public function eliminarArchivo($archivoId)
    {
        $archivo = Archivo::findOrFail($archivoId);

        // Eliminar archivo del almacenamiento
        if (Storage::disk('public')->exists($archivo->ruta_archivo)) {
            Storage::disk('public')->delete($archivo->ruta_archivo);
        }

        // Eliminar registro de la base de datos
        $archivo->delete();

        return [
            'success' => true,
            'message' => 'Archivo eliminado correctamente',
        ];
    }
}