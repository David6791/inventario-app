@include('common.modalHeader')
<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Nombre del Permiso</label>
            <input type="text" wire:model.lazy="permissionName" class="form-control" placeholder="ej. permiso">
            @error('permissionName') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>
@include('livewire.permisos.partials.modalFooter')