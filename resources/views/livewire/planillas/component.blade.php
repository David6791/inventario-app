<div class="card border-left-primary">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <h6 class="card-title text-primary"> {{$pageTitle}} / {{$componentName}}</h6>
        </div>
    </div>
    <div class="card-body">
        <form action="">
            <div class="row">
                <div class="col-md-2"><h6 class="text-center text-warning" wire:loading> Por favor espere...</h6></div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="" wire:model.lazy="year" class="form-control" id="">
                            <option value="Elegir">Elegir Año</option>
                            @foreach ($years as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre_year }}</option>
                            @endforeach
                        </select>
                        @error('year') <span class="text-danger er">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <select name="" wire:model.lazy="mes" class="form-control" id="">
                            <option value="Elegir">Elegir Mes</option>
                            @foreach ($meses as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre_mes }}</option>
                            @endforeach
                        </select>
                        @error('mes') <span class="text-danger er">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="button" wire:click.prevent="cargar_datos_planilla()" class="btn btn-success"> <i class="fas fa-download"></i> Cargar Datos</button>
                </div>
            </div>
        </form><hr>
        <p class="text-primary">Planilla de Sueldos y Salarios Correspondiente al Mes de: {{$nombre_mes}} del Año: {{$nombre_year}}</p>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover dataTable dtr-inline table-sm text-small small">
                    <thead>
                        <tr>
                            <th colspan="7"></th>
                            <th colspan="5">Descuentos</th>
                            <th colspan="3"></th>
                        </tr>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nomina</th>
                            <th>Cargo</th>
                            <th>D. Trabajados</th>
                            <th>Haber Basico</th>
                            <th>Bono Antig.</th>
                            <!--th>Hrs. Extras</th>
                            <th>Rec. Noctur.</th-->
                            <th>T. Ganado</th>
                            <th>AFPs</th>
                            <th>Riesgo Comun</th>
                            <th>Comisiones</th>
                            <th>Aporte Solidario</th>
                            <th>RC-IVA</th>
                            <th>T. Descuentos</th>
                            <th>L. Pagable</th>
                            <th>Op.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($listas_empleados as $le)
                            <tr>
                                <td>{{$le->id_planilla}}</td>
                                <td>{{$le->nombres}} {{$le->apellidos}}</td>
                                <td>{{$le->nombre_cargo}}</td>
                                <td>
                                    @if($le->finalizado === 1)
                                    <center><input disabled type="number" onchange="ingresar_dias_trabajados('{{$le->id_planilla}}')" id="{{$le->id_planilla}}" style="width : 50px;" value="{{$le->dias_trabajados}}" class="form-control form-control-sm"></center>
                                    @else
                                    <center><input type="number" onchange="ingresar_dias_trabajados('{{$le->id_planilla}}')" id="{{$le->id_planilla}}" style="width : 50px;" value="{{$le->dias_trabajados}}" class="form-control form-control-sm"></center>
                                    @endif
                                </td>
                                <td>{{$le->haber_basico}}</td>
                                <td>{{$le->bono_antiguedad}}</td>
                                <!--td>{{$le->extras}}</td>
                                <td>{{$le->nocturnos}}</td-->
                                <td>{{$le->total_ganado}}</td>
                                <td>{{$le->afp}}</td>
                                <td>{{$le->anticipos}}</td> <!--riego comun-->
                                <td>{{$le->extras}}</td> <!--comisiones -->
                                <td>{{$le->aporte_solidario}}</td>
                                <td>{{$le->iva}}</td>

                                <td>{{$le->descuentos}}</td>
                                <td>{{$le->liquido_pagable}}</td>
                                <td>
                                    @if($le->finalizado === 1)
                                    <button disabled class="btn btn-danger btn-xs" title="Quitar de la Lista" onclick="quitar_empleado_planilla('{{$le->id_planilla}}')"> <i class="fas fa-minus-circle"></i> </button></td>
                                    @else
                                    <button class="btn btn-danger btn-xs" title="Quitar de la Lista" onclick="quitar_empleado_planilla('{{$le->id_planilla}}')"> <i class="fas fa-minus-circle"></i> </button></td>
                                    @endif
                            </tr>
                        @empty
                            <tr>

                            </tr>
                        @endforelse
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <center>
                    @if(1 === 1)
                        <button class="btn btn-danger btn-sm" onclick="">PLANILLA CERRADA</button>
                    @else
                        <button class="btn btn-success btn-sm" onclick="finalizar_planilla()"> <i class="fas fa-store-slash"></i> FINALIZAR LLENADO DE PLANILLA</button>
                    @endif
                </center>
            </div>
            <div class="col-md-6">
                <center>
                    <a class="btn btn-primary btn-sm" target="_blank" href="report_planilla_sueldos/{{ $year }}/{{ $mes }}"> <i class="fas fa-print"></i> IMPRIMIR PLANILLA</a>
                </center>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('actualizado_salario',msg => {
            Toast.fire({icon: 'success',title: msg})
        });
        window.livewire.on('empleado-deleted',msg => {
            Toast.fire({icon: 'success',title: msg})
        });
    });
    function ingresar_dias_trabajados(id){
        var x = $('input[id='+id+']').val();
        window.livewire.emit('agregar_dias_trabajados', id, x);
    }
    function quitar_empleado_planilla(id){
        window.livewire.emit('quitar_empleado_planillas', id);
    }
    function finalizar_planilla(){
        Swal.fire({
            title: 'Confirmar',
            text: 'Estas Seguro de Finalizar el Llenado de esta Planilla',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'CERRAR',
            CancelButtonColor: '#fff',
            confirmButtonColor: '#3b3f5c',
            confirmButtonText: 'Aceptar'
        }).then(function(result){
            if(result.value){
                window.livewire.emit('fin_planilla');
                swal.close();
            }
        });
    }
</script>
