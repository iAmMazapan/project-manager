<?php

namespace App\Livewire;

use App\Models\Tarea;
use App\Traits\RegistraActividad;
use Livewire\Component;

class TareaEstadoSelector extends Component
{
    use RegistraActividad;
    
    public $tareaId;
    public $estado;
    
    public function mount(Tarea $tarea)
    {
        $this->tareaId = $tarea->id;
        $this->estado = $tarea->estado;
    }
    
    public function updatedEstado($value)
    {
        $tarea = Tarea::findOrFail($this->tareaId);
        $estadoAnterior = $tarea->estado;
        
        $tarea->update([
            'estado' => $value
        ]);
        
        $this->registrarActividad(
            auth()->id(), 
            'editar', 
            'tarea', 
            $tarea->id, 
            "Cambio de estado de la tarea '{$tarea->titulo}' de '{$estadoAnterior}' a '{$value}'"
        );
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Estado actualizado correctamente'
        ]);
    }
    
    public function render()
    {
        return view('livewire.tarea-estado-selector');
    }
}