@include('common.modalHeader')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombres</label>
            <input type="text" wire:model.lazy="nombres" class="form-control" placeholder="">
            @error('nombres') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Apellidos</label>
            <input type="text" wire:model.lazy="apellidos" class="form-control" placeholder="">
            @error('apellidos') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-3">
        <div class="form-group">
            <label>Cedula de Identidad</label>
            <input type="text" wire:model.lazy="ci" class="form-control" placeholder="">
            @error('ci') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Cargo Empleado</label>
            <select name="" wire:model.lazy="cargo" class="form-control" id="">
                <option value="Elegir">Elegir</option>
                @foreach ($cargos as $c)
                    <option value="{{ $c->id }}">{{ $c->nombre_cargo }}</option>
                @endforeach
            </select>
            @error('cargo') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-5">
        <div class="form-group">
            <label>Correo Electronico</label>
            <input type="text" wire:model.lazy="email" class="form-control" placeholder="">
            @error('email') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Fecha de Contratacion</label>
            <input type="date" wire:model.lazy="fecha_contratacion" class="form-control" placeholder="">
            @error('fecha_contratacion') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Telefono</label>
            <input type="text" wire:model.lazy="telefono" class="form-control" placeholder="">
            @error('telefono') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Estado</label>
            <select name="" wire:model.lazy="status" class="form-control" id="">
                <option value="Elegir">Elegir</option>
                <option value="Active">Activo</option>
                <option value="Locked">Bloqueado</option>
            </select>
            @error('status') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-5">
        <div class="form-group">
            <label>Direccion</label>
            <input type="text" wire:model.lazy="direccion" class="form-control" placeholder="">
            @error('direccion') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Imagen</label>
            <input type="file" wire:model.lazy="image" accept="image/png, image/jpeg, image/gif" class="form-control">
            @error('image') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>
@include('livewire.empleados.partials.modalFooter')
