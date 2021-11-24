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
                        <th class="table-th text-white">USUARIO</th>
                        <th class="table-th text-white">CI</th>
                        <th class="table-th text-white text-center">TELEFONO</th>
                        <th class="table-th text-white text-center">EMAIL</th>
                        <th class="table-th text-white text-center">PERFIL</th>
                        <th class="table-th text-white text-center">STATUS</th>
                        <th class="table-th text-white text-center">IMAGEN</th>
                        <th class="table-th text-white text-center">ACCION </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $r)
                        <tr>
                            <td>{{$r->name}}</td>
                            <td>{{$r->ci}}</td>
                            <td>{{$r->phone}}</td>
                            <td>{{$r->email}}</td>
                            <td>{{$r->profile}}</td>
                            <td>
                                <span class="badge {{ $r->status == 'ACTIVE' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{$r->status}}</span>
                            </td>
                            <td class="text-center">
                                @if($r->image != null)
                                    <span>
                                        <img src="{{ asset('storage/usuarios/' . $r->image) }}" alt="" class="img-circle" width="40">
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0)" wire:click="Edit({{$r->id}})" class="btn btn-info btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="Confirm('{{$r->id}}')" class="btn btn-danger btn-sm" title="Borrar">
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
    @include('livewire.users.form')
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('show-modal',msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('hide-modal',msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('user-added',msg => {
            $('#theModal').modal('hide');
            Toast.fire({icon: 'success',title: msg})
        });
        window.livewire.on('user-updated',msg => {
            $('#theModal').modal('hide');
            Toast.fire({icon: 'success',title: msg})
        });
        window.livewire.on('user-deleted',msg => {
            Toast.fire({icon: 'success',title: msg})
        });
        window.livewire.on('user-withsales',msg => {
            Toast.fire({icon: 'success',title: msg})
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
</script>
