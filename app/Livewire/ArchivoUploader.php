<?php

namespace App\Livewire;

use App\Services\ArchivoService;
use Livewire\Component;
use Livewire\WithFileUploads;

class ArchivoUploader extends Component
{
    use WithFileUploads;
    
    public $entidadId;
    public $tipoEntidad;
    public $archivos = [];
    public $archivosCargados = [];
    
    public function mount($entidadId, $tipoEntidad)
    {
        $this->entidadId = $entidadId;
        $this->tipoEntidad = $tipoEntidad;
    }
    
    public function uploadArchivos()
    {
        $this->validate([
            'archivos.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);
        
        $archivoService = app(ArchivoService::class);
        
        foreach ($this->archivos as $archivo) {
            $result = $archivoService->guardarArchivo($archivo, $this->tipoEntidad, $this->entidadId);
            
            if ($result['success']) {
                $this->archivosCargados[] = $result['archivo'];
            }
        }
        
        $this->archivos = [];
        
        $this->dispatchBrowserEvent('notify', [
            'type' => 'success',
            'message' => 'Archivos subidos correctamente'
        ]);
        
        $this->emit('archivosActualizados');
    }
    
    public function render()
    {
        return view('livewire.archivo-uploader');
    }
}