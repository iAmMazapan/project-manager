<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\Tarea;
use App\Models\Usuario;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Para administradores: estadísticas generales
        if (auth()->user()->esAdministrador()) {
            $totalProyectos = Proyecto::count();
            $totalTareas = Tarea::count();
            $totalUsuarios = Usuario::count();
            
            $proyectosRecientes = Proyecto::select('proyectos.*')
                ->distinct()
                ->latest('fecha_creacion')
                ->take(5)
                ->get();
                
            $tareasRecientes = Tarea::with(['proyecto', 'usuario'])
                ->latest('fecha_creacion')
                ->take(5)
                ->get();
                
            $tareasPorEstado = [
                'por hacer' => Tarea::where('estado', 'por hacer')->count(),
                'en progreso' => Tarea::where('estado', 'en progreso')->count(),
                'completada' => Tarea::where('estado', 'completada')->count(),
            ];
        } 
        // Para usuarios normales: solo sus proyectos y tareas
        else {
            $totalProyectos = auth()->user()->proyectos()->count();
            $totalTareas = Tarea::where('usuario_id', auth()->id())->count();
            $totalUsuarios = 0;
            
            $proyectosRecientes = auth()->user()->proyectos()
                ->select('proyectos.*')
                ->distinct()
                ->latest('fecha_creacion')
                ->take(5)
                ->get();
                
            $tareasRecientes = Tarea::where('usuario_id', auth()->id())
                ->with(['proyecto', 'usuario'])
                ->latest('fecha_creacion')
                ->take(5)
                ->get();
                
            $tareasPorEstado = [
                'por hacer' => Tarea::where('usuario_id', auth()->id())
                    ->where('estado', 'por hacer')
                    ->count(),
                'en progreso' => Tarea::where('usuario_id', auth()->id())
                    ->where('estado', 'en progreso')
                    ->count(),
                'completada' => Tarea::where('usuario_id', auth()->id())
                    ->where('estado', 'completada')
                    ->count(),
            ];
        }
        
        return view('dashboard', compact(
            'totalProyectos',
            'totalTareas',
            'totalUsuarios', 
            'proyectosRecientes',
            'tareasRecientes',
            'tareasPorEstado'
        ));
    }
}