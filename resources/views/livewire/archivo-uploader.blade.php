<div>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Archivos (PDF, DOC, DOCX, JPG, PNG)</label>
        <label for="file-upload" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-slate-500 hover:bg-slate-100 transition-all cursor-pointer">
            <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>

                <div class="flex text-sm text-gray-600">
                    <span class="font-medium text-slate-700">Subir archivos</span>
                    <input id="file-upload"
                           wire:model="archivos"
                           multiple
                           type="file"
                           class="sr-only"
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    <p class="pl-1">o arrastra y suelta</p>
                </div>

                <p class="text-xs text-gray-500">
                    PDF, DOC, DOCX, JPG, PNG hasta 10MB
                </p>
            </div>
        </label>
    </div>
    
    <div wire:loading wire:target="archivos">
        <p class="text-sm text-blue-500">Cargando archivos...</p>
    </div>
    
    @error('archivos.*')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
    
    @if(count($archivos) > 0)
        <div class="mt-4">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Archivos seleccionados:</h4>
            <ul class="list-disc pl-5">
                @foreach($archivos as $archivo)
                    <li class="text-sm text-gray-600">{{ $archivo->getClientOriginalName() }}</li>
                @endforeach
            </ul>
            
            <button type="button"
                    wire:click="uploadArchivos"
                    wire:loading.attr="disabled"
                    class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-slate-700 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500">
                <span wire:loading.remove wire:target="uploadArchivos">Subir ahora</span>
                <span wire:loading wire:target="uploadArchivos">Subiendo...</span>
            </button>
        </div>
    @endif
    
    <script>
        window.addEventListener('notify', event => {
            window.dispatchEvent(new CustomEvent('notify', { 
                detail: {
                    type: event.detail.type,
                    message: event.detail.message
                }
            }
        });
    </script>
</div>