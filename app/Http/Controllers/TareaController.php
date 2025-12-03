<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\Proyecto;
use App\Models\Usuario;
use App\Services\ArchivoService;
use Illuminate\Http\Request;
use App\Traits\RegistraActividad;
//use App\Traits\Autoriza; 

class TareaController extends Controller
{
    use RegistraActividad;
    //use Autoriza;
    
    protected $archivoService;
    
    public function __construct(ArchivoService $archivoService)
    {
        $this->archivoService = $archivoService;
    }
    
    public function index()
    {
        // Filtrar tareas según el rol
        if (auth()->user()->esAdministrador()) {
            $tareas = Tarea::with(['proyecto', 'usuario'])->get();
        } else {
            $tareas = Tarea::where('usuario_id', auth()->id())
                ->with(['proyecto', 'usuario'])
                ->get();
        }
        
        return view('tareas.index', compact('tareas'));
    }
    
    public function create(Request $request)
    {
        $this->authorize('create', Tarea::class);
        
        // Si se recibió un ID de proyecto, pre-seleccionarlo
        $proyectoId = $request->query('proyecto_id');
        
        if (auth()->user()->esAdministrador()) {
            $proyectos = Proyecto::all();
            $usuarios = Usuario::where('estado', true)->get();
        } else {
            $proyectos = auth()->user()->proyectos;
            $usuarios = Usuario::whereHas('proyectos', function ($query) use ($proyectoId) {
                $query->where('proyectos.id', $proyectoId);
            })->where('estado', true)->get();
        }
        
        return view('tareas.create', compact('proyectos', 'usuarios', 'proyectoId'));
    }
    
    public function store(Request $request)
    {
        $this->authorize('create', Tarea::class);
        
        $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:por hacer,en progreso,completada',
            'proyecto_id' => 'required|exists:proyectos,id',
            'usuario_id' => 'required|exists:usuarios,id',
            'archivos.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);
        
        // Verificar que el usuario tiene acceso al proyecto
        $proyecto = Proyecto::findOrFail($request->proyecto_id);
        if (!auth()->user()->esAdministrador() && !$proyecto->usuarios->contains(auth()->id())) {
            return redirect()->route('tareas.index')
                ->with('error', 'No tienes permisos para crear tareas en este proyecto');
        }
        
        $tarea = Tarea::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => $request->estado,
            'proyecto_id' => $request->proyecto_id,
            'usuario_id' => $request->usuario_id,
        ]);
        
        // Manejar archivos
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $this->archivoService->guardarArchivo($archivo, 'tarea', $tarea->id);
            }
        }
        
        $this->registrarActividad(
            auth()->id(), 
            'crear', 
            'tarea', 
            $tarea->id, 
            'Creación de la tarea ' . $tarea->titulo
        );
        
        return redirect()->route('tareas.index')
            ->with('success', 'Tarea creada exitosamente');
    }
    
    public function show(Tarea $tarea)
    {
        $this->authorize('view', $tarea);
        
        $archivos = $tarea->archivos;
        
        return view('tareas.show', compact('tarea', 'archivos'));
    }
    
    public function edit(Tarea $tarea)
    {
        $this->authorize('update', $tarea);
        
        if (auth()->user()->esAdministrador()) {
            $proyectos = Proyecto::all();
            $usuarios = Usuario::where('estado', true)->get();
        } else {
            $proyectos = auth()->user()->proyectos;
            $usuarios = Usuario::whereHas('proyectos', function ($query) use ($tarea) {
                $query->where('proyectos.id', $tarea->proyecto_id);
            })->where('estado', true)->get();
        }
        
        return view('tareas.edit', compact('tarea', 'proyectos', 'usuarios'));
    }
    
    public function update(Request $request, Tarea $tarea)
    {
        $this->authorize('update', $tarea);
        
        $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|in:por hacer,en progreso,completada',
            'proyecto_id' => 'required|exists:proyectos,id',
            'usuario_id' => 'required|exists:usuarios,id',
            'archivos.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);
        
        // Verificar que el usuario tiene acceso al proyecto
        $proyecto = Proyecto::findOrFail($request->proyecto_id);
        if (!auth()->user()->esAdministrador() && !$proyecto->usuarios->contains(auth()->id())) {
            return redirect()->route('tareas.index')
                ->with('error', 'No tienes permisos para editar tareas en este proyecto');
        }
        
        $tarea->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estado' => $request->estado,
            'proyecto_id' => $request->proyecto_id,
            'usuario_id' => $request->usuario_id,
        ]);
        
        // Manejar archivos nuevos
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $this->archivoService->guardarArchivo($archivo, 'tarea', $tarea->id);
            }
        }
        
        $this->registrarActividad(
            auth()->id(), 
            'editar', 
            'tarea', 
            $tarea->id, 
            'Actualización de la tarea ' . $tarea->titulo
        );
        
        return redirect()->route('tareas.show', $tarea)
            ->with('success', 'Tarea actualizada exitosamente');
    }
    
    public function destroy(Tarea $tarea)
    {
        $this->authorize('delete', $tarea);
        
        $tituloTarea = $tarea->titulo;
        
        // Eliminar archivos asociados
        foreach ($tarea->archivos as $archivo) {
            $this->archivoService->eliminarArchivo($archivo->id);
        }
        
        $tarea->delete();
        
        $this->registrarActividad(
            auth()->id(), 
            'eliminar', 
            'tarea', 
            $tarea->id, 
            'Eliminación de la tarea ' . $tituloTarea
        );
        
        return redirect()->route('tareas.index')
            ->with('success', 'Tarea eliminada exitosamente');
    }
    
    public function actualizarEstado(Request $request, Tarea $tarea)
    {
        $this->authorize('update', $tarea);
        
        $request->validate([
            'estado' => 'required|in:por hacer,en progreso,completada',
        ]);
        
        $estadoAnterior = $tarea->estado;
        
        $tarea->update([
            'estado' => $request->estado,
        ]);
        
        $this->registrarActividad(
            auth()->id(), 
            'editar', 
            'tarea', 
            $tarea->id, 
            "Cambio de estado de la tarea '{$tarea->titulo}' de '{$estadoAnterior}' a '{$request->estado}'"
        );
        
        return redirect()->back()
            ->with('success', 'Estado de la tarea actualizado exitosamente');
    }
}