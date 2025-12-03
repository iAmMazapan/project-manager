<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Usuario;
use App\Services\ArchivoService;
use Illuminate\Http\Request;
use App\Traits\RegistraActividad;
//use App\Traits\Autoriza;

class ProyectoController extends Controller
{
    use RegistraActividad;
   // use Autoriza;
    
    protected $archivoService;
    
    public function __construct(ArchivoService $archivoService)
    {
        $this->archivoService = $archivoService;
    }
    
    public function index()
    {
        // Filtrar proyectos según el rol
        if (auth()->user()->esAdministrador()) {
            $proyectos = Proyecto::all();
        } else {
            $proyectos = auth()->user()->proyectos;
        }
        
        return view('proyectos.index', compact('proyectos'));
    }
    
    public function create()
    {
        $this->authorize('create', Proyecto::class);
        
        $usuarios = Usuario::where('estado', true)->get();
        return view('proyectos.create', compact('usuarios'));
    }
    
    public function store(Request $request)
    {
        $this->authorize('create', Proyecto::class);
        
        $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'usuarios' => 'required|array|min:1',
            'archivos.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);
        
        $proyecto = Proyecto::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);
        
       $proyecto->usuarios()->sync($request->usuarios);
        
        // Manejar archivos
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $this->archivoService->guardarArchivo($archivo, 'proyecto', $proyecto->id);
            }
        }
        
        $this->registrarActividad(
            auth()->id(), 
            'crear', 
            'proyecto', 
            $proyecto->id, 
            'Creación del proyecto ' . $proyecto->titulo
        );
        
        return redirect()->route('proyectos.index')
            ->with('success', 'Proyecto creado exitosamente');
    }
    
    public function show(Proyecto $proyecto)
    {
        $this->authorize('view', $proyecto);
        
        $tareas = $proyecto->tareas;
        $archivos = $proyecto->archivos;
        
        return view('proyectos.show', compact('proyecto', 'tareas', 'archivos'));
    }
    
    public function edit(Proyecto $proyecto)
    {
        $this->authorize('update', $proyecto);
        
        $usuarios = Usuario::where('estado', true)->get();
        $proyectoUsuarios = $proyecto->usuarios->pluck('id')->toArray();
        
        return view('proyectos.edit', compact('proyecto', 'usuarios', 'proyectoUsuarios'));
    }
    
    public function update(Request $request, Proyecto $proyecto)
    {
        $this->authorize('update', $proyecto);
        
        $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'usuarios' => 'required|array|min:1',
            'archivos.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);
        
        $proyecto->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);
        
        $proyecto->usuarios()->sync($request->usuarios);
        
        // Manejar archivos nuevos
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $this->archivoService->guardarArchivo($archivo, 'proyecto', $proyecto->id);
            }
        }
        
        $this->registrarActividad(
            auth()->id(), 
            'editar', 
            'proyecto', 
            $proyecto->id, 
            'Actualización del proyecto ' . $proyecto->titulo
        );
        
        return redirect()->route('proyectos.show', $proyecto)
            ->with('success', 'Proyecto actualizado exitosamente');
    }
    
    public function destroy(Proyecto $proyecto)
    {
        $this->authorize('delete', $proyecto);
        
        $tituloProyecto = $proyecto->titulo;
        
        // Eliminar archivos asociados
        foreach ($proyecto->archivos as $archivo) {
            $this->archivoService->eliminarArchivo($archivo->id);
        }
        
        $proyecto->delete();
        
        $this->registrarActividad(
            auth()->id(), 
            'eliminar', 
            'proyecto', 
            $proyecto->id, 
            'Eliminación del proyecto ' . $tituloProyecto
        );
        
        return redirect()->route('proyectos.index')
            ->with('success', 'Proyecto eliminado exitosamente');
    }
}