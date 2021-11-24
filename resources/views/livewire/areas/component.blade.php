<div class="card border-left-primary">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h6 class="card-title text-primary"> {{$componentName}} / {{$pageTitle}}</h6>
            <a class="btn btn-success btn-sm" href="javascript:void(0)" role="button" data-toggle="modal" data-target="#theModal">
                Agregar Area
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
                        <th class="table-th text-white">ID</th>
                        <th class="table-th text-white">NOMBRE AREA</th>
                        <th class="table-th text-white">RESPONSABLE</th>
                        <th class="table-th text-white">C.I.</th>
                        <th class="table-th text-white">CARGO</th>
                        <th class="table-th text-white">ESTADO</th>
                        <th class="table-th text-white">ACCIONes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($areas as $a)
                        <tr>
                            <td><h6 class="text-center">{{$a->id}} </h6></td>
                            <td class="">{{$a->name}}</td>
                            <td class="">{{$a->name_responsable}}</td>
                            <td class="">{{$a->ci_responsable}}</td>
                            <td class="">{{$a->position}}</td>
                            <td class="">{{$a->status}}</td>
                            <td class=""></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{$areas->links()}}
        </div>
    </div>
    <div class="card-footer"></div>
</div>
@include('livewire.areas.form')
