<div>
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700">Buscar usuarios</label>
        <input type="text" wire:model.debounce.300ms="search" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Nombre o email...">
    </div>
    
    <div class="mt-4 mb-4">
        <h4 class="text-sm font-medium text-gray-700 mb-2">Usuarios seleccionados:</h4>
        <div>
            @foreach($selectedUsuarios as $selectedId)
                @php $u = $usuarios->firstWhere('id', $selectedId); @endphp
                @if($u)
                <div class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2 mb-2">
                    {{ $u->nombre_completo }}
                    <button type="button" wire:click="toggleUsuario({{ $u->id }})" class="ml-1 text-blue-500 hover:text-blue-700">
                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                @endif
            @endforeach
        </div>
    </div>
    
    <div class="mt-4">
        <h4 class="text-sm font-medium text-gray-700 mb-2">Usuarios disponibles:</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($usuarios as $usuario)
                <div class="flex items-center">
                    <input id="usuario-{{ $usuario->id }}" 
                           type="checkbox" 
                           name="usuarios[]" 
                           value="{{ $usuario->id }}"
                           wire:click="toggleUsuario({{ $usuario->id }})"
                           @if(in_array($usuario->id, $selectedUsuarios)) checked @endif
                           class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="usuario-{{ $usuario->id }}" class="ml-2 block text-sm text-gray-900">
                        {{ $usuario->nombre_completo }} ({{ $usuario->email }})
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    
    @foreach($selectedUsuarios as $selectedId)
        <input type="hidden" name="usuarios[]" value="{{ $selectedId }}">
    @endforeach
</div>