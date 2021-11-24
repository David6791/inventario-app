<div class="row">
    <div class="col-sm-12 col-md-3">
        <div class="form-group">
            <label>Departamento:</label>
            <select name="" id="" class="form-control select2bs4" onchange="load_provinces()">
                <option value="">Elegir</option>
                @foreach ($depart as $d)
                    <option value="{{$d->id}}">{{$d->name_department}}</option>
                @endforeach
            </select>
            @error('name_responsable') <span class="text-danger er">{{ $message }}</span> @enderror
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
<script>
    function load_provinces(id){
        alert("ASdsadsad")
        window.livewire.emit('revokeall', id);
        swal.close();
    }
</script>
<script>
    $(function () {
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        })
    })
</script>
