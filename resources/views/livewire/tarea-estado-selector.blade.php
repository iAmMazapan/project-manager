<div>
    <select wire:model="estado" class="form-select rounded-md shadow-sm">
        <option value="por hacer">Por hacer</option>
        <option value="en progreso">En progreso</option>
        <option value="completada">Completada</option>
    </select>
    
    <script>
        window.addEventListener('notify', event => {
            window.dispatchEvent(new CustomEvent('notify', { 
                detail: {
                    type: event.detail.type,
                    message: event.detail.message
                }
            }));
        });
    </script>
</div>