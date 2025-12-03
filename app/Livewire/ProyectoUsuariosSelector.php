<?php

namespace App\Livewire;

use App\Models\Usuario;
use Livewire\Component;

class ProyectoUsuariosSelector extends Component
{
    public $usuarios = [];
    public $selectedUsuarios = [];
    public $search = '';
    
    public function mount($selectedUsuarios = [])
    {
        $this->usuarios = Usuario::where('estado', true)->get();
        $this->selectedUsuarios = $selectedUsuarios;
    }
    
    public function updatedSearch()
    {
        if (empty($this->search)) {
            $this->usuarios = Usuario::where('estado', true)->get();
        } else {
            $this->usuarios = Usuario::where('estado', true)
                ->where(function ($query) {
                    $query->where('nombre_completo', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->get();
        }
    }
    
    public function toggleUsuario($usuarioId)
    {
        if (in_array($usuarioId, $this->selectedUsuarios)) {
            $this->selectedUsuarios = array_diff($this->selectedUsuarios, [$usuarioId]);
        } else {
            $this->selectedUsuarios[] = $usuarioId;
        }
    }
    
    public function render()
    {
        return view('livewire.proyecto-usuarios-selector');
    }
}