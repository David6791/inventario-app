<div class="card border-left-primary">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h6 class="card-title text-primary"> {{$componentName}} / {{$pageTitle}}</h6>
            <a class="btn btn-success btn-sm" href="javascript:void(0)" role="button" data-toggle="modal" data-target="#theModal">
                Agregar
                <i class="fas fa-plus fa-sm fa-fw text-gray-400"></i>
            </a>
        </div>
    </div>
    <div class="card-body">
        @include('common.searchbox')
        <div class="table-responsive">
            <table class="table table-bordered table-striped mt-1">
                <thead class="text-white" style="background: #003471">
                    <tr>
                        <th class="table-th text-white">NOMBRES Y APELLIDOS</th>
                        <th class="table-th text-white">CI</th>
                        <th class="table-th text-white text-center">TELEFONO</th>
                        <th class="table-th text-white text-center">FECHA CONTRATACION</th>
                        <th class="table-th text-white text-center">TIPO</th>
                        <th class="table-th text-white text-center">ESTADO</th>
                        <th class="table-th text-white text-center">IMAGEN</th>
                        <th class="table-th text-white text-center">ACCION </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $r)
                        <tr>
                            <td>{{$r->nombres}} {{$r->apellidos}}</td>
                            <td>{{$r->ci}}</td>
                            <td>{{$r->telefono}}</td>
                            <td>{{$r->fecha_contratacion}}</td>
                            <td>{{$r->nombre_cargo}}</td>
                            <td>
                                <button href="javascript:void(0)" onclick="Baja_empleado('{{$r->id_em}}')" class="btn badge {{ $r->status == 'ACTIVE' ? 'badge-success btn-success' : 'badge-danger btn-danger' }} text-uppercase">{{$r->status}}</button>
                            </td>
                            <td class="text-center">
                                @if($r->image != null)
                                    <span>
                                        <img src="{{ asset('storage/empleados/' . $r->image) }}" alt="" class="img-circle" width="40">
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0)" wire:click="Edit_empleados({{$r->id_em}})" class="btn btn-info btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="Confirm('{{$r->id_em}}')" class="btn btn-danger btn-sm" title="Borrar">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$data->links()}}
        </div>
    </div>
    <div class="card-footer">
    </div>
    <!--Aqui formulario-->
    @include('livewire.empleados.form')
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('show-modal',msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('hide-modal',msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('empleado-added',msg => {
            $('#theModal').modal('hide');
            Toast.fire({icon: 'success',title: msg})
        });
        window.livewire.on('empleado-updated',msg => {
            $('#theModal').modal('hide');
            Toast.fire({icon: 'success',title: msg})
        });
        window.livewire.on('user-deleted',msg => {
            Toast.fire({icon: 'success',title: msg})
        });
        window.livewire.on('user-withsales',msg => {
            Toast.fire({icon: 'success',title: msg})
        });
        window.livewire.on('empleado-bajas',msg => {
            Toast.fire({icon: 'success',title: msg})
        });
        window.livewire.on('empleado-activo',msg => {
            Toast.fire({icon: 'error',title: msg})
        });
    });
    function Confirm(id){
        Swal.fire({
            title: 'Confirmar',
            text: 'Confirmas Eliminar el Usuario',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'CERRAR',
            CancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'Aceptar'
        }).then(function(result){
            if(result.value){
                window.livewire.emit('deleteRow', id);
                swal.close();
            }
        });
    }
    function Baja_empleado(id){
        Swal.fire({
            title: 'Confirmar',
            text: 'Confirmas modificar el Estado del Empleado',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'CERRAR',
            CancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'Aceptar'
        }).then(function(result){
            if(result.value){
                window.livewire.emit('baja_empleado', id);
                swal.close();
            }
        });
    }
</script>
