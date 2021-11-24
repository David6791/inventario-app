@include('livewire.areas.partials.modalHeader')
<div class="row">
    <div class="col-sm-12 col-md-8">
        <div class="form-group">
            <label>Nombre del Area:</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej. Admin">
            @error('name') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre Responsable:</label>
            <input type="text" wire:model.lazy="name_responsable" class="form-control" placeholder="ej. Admin">
            @error('name_responsable') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>C.I.:</label>
            <input type="text" wire:model.lazy="ci_responsable" class="form-control" placeholder="ej. Admin">
            @error('ci_responsable') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
            <label>Expedido:</label>
            <select name="" id="" class="form-control">
                <option value="">Elegir</option>
                <option value="Pt.">Potosi</option>
                <option value="Ch.">Chuquisaca</option>
                <option value="Lp.">La Paz</option>
            </select>
            @error('name_responsable') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-3">
        <div class="form-group">
            <label>Departamento</label>
            <select class="form-control" id="select" wire:change="load_provinces($event.target.value)">
                <option value="Elegir">Elegir</option>
                @foreach($depart as $d)
                    <option name="id_department" value="{{$d->id}}">{{$d->name_department}}</option>
                @endforeach
            </select>
            @error('id_department') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-3">
        <div class="form-group">
            <label>Provincia:</label>
            <select name="" id="" class="form-control">
                <option value="">Elegir</option>
            </select>
            @error('name_responsable') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-3">
        <div class="form-group">
            <label>Municipio:</label>
            <select name="" id="" class="form-control">
                <option value="">Elegir</option>
            </select>
            @error('name_responsable') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-3">
        <div class="form-group">
            <label>Comunidad:</label>
            <select name="" id="" class="form-control">
                <option value="">Elegir</option>
            </select>
            @error('name_responsable') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Bloque:</label>
            <select name="" id="" class="form-control select2">
                <option value="">Elegir</option>
                <option value="Pt.">Potosi</option>
                <option value="Ch.">Chuquisaca</option>
                <option value="Lp.">La Paz</option>
            </select>
            @error('name_responsable') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Cargo Responsable:</label>
            <select name="" id="" class="form-control">
                <option value="">Elegir</option>
                <option value="Pt.">Potosi</option>
                <option value="Ch.">Chuquisaca</option>
                <option value="Lp.">La Paz</option>
            </select>
            @error('name_responsable') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>
@include('livewire.areas.partials.modalFooter')
<script>

</script>

