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
                    <button type="button" wire:click.prevent="cargar_datos_planilla_iva()" class="btn btn-success"> <i class="fas fa-download"></i> Cargar Datos</button>
                </div>
            </div>
        </form><hr>
        <p class="text-primary">PLANILLA IMPOSITIVA DEL RC - IVA Correspondiente al Mes de: {{$nombre_mes}} del Año: {{$nombre_year}}</p>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover dataTable dtr-inline table-sm text-small small">
                    <thead>
                        <tr>
                            <th colspan="10"></th>
                            <th colspan="2">Descuentos</th>
                            <th colspan="3"></th>
                            <th colspan="5"></th>
                        </tr>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th  style="width: 150px">Nomina</th>
                            <th>F Presentadas</th>
                            <th>S Neto</th>
                            <th>M no Imponible</th>
                            <th>D Base Impobible</th>
                            <th>Impuesto</th>
                            <th>FORM 110</th>
                            <th>2 Salarios Min</th>
                            <th>Imp Neto RC-IVA</th>

                            <th>FISCO</th>
                            <th>DEPENDIENTE</th>

                            <th>DEL PERIODO ANTERIOR</th>
                            <th>MANTO DE VALOR</th>
                            <th>SALDO ACTUALIZADO</th>

                            <th>SALDO A FAVOR DEP</th>
                            <th>SALDO UTILIZADO</th>
                            <th>IMPUESTO RC- IVA RETENIDO</th>
                            <th>SALDO MES SIGUIENTE F DEP</th>

                            <th>Op.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($listas_empleados as $le)
                            <tr>
                                <td>{{$le->id_planilla}}</td>
                                <td>{{$le->nombres}} {{$le->apellidos}}</td>
                                <td>
                                    @if($le->impuestos_control === 1)
                                    <center><input disabled type="number" onchange="ingresar_dias_facturas('{{$le->id_planilla}}')" id="{{$le->id_planilla}}" style="width : 50px;" value="{{$le->facturas_presentadas}}" class="form-control form-control-sm"></center>
                                    @else
                                    <center><input type="number" onchange="ingresar_dias_facturas('{{$le->id_planilla}}')" id="{{$le->id_planilla}}" style="width : 50px;" value="{{$le->facturas_presentadas}}" class="form-control form-control-sm"></center>
                                    @endif
                                </td>
                                <td>{{$le->liquido_pagable}}</td>
                                <td>{{$le->minimo_no_imponible}}</td>
                                <td>{{$le->diferencia_base_imponible}}</td>
                                <td>{{$le->iva_reducido}}</td>
                                <td>{{$le->form110}}</td>
                                <td>{{$le->salario_minimo}}</td>
                                <td>{{$le->impuesto_neto}}</td>

                                <td>{{$le->fisco}}</td>
                                <td>{{$le->dependiente}}</td>

                                <td>{{$le->saldo_f_per_anterior}}</td>
                                <td>{{$le->mantenimiento_valor}}</td>
                                <td>{{$le->saldo_actualizado}}</td>

                                <td>{{$le->saldo_favor}}</td>

                                <td>{{$le->saldo_utilizado}}</td>

                                <td>{{$le->impuesto_retenido}}</td>
                                <td>{{$le->saldo_siguiente_mes}}</td>
                                <td>
                                    @if($le->impuestos_control === 1)
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
        window.livewire.on('actualizado_impuestos',msg => {
            Toast.fire({icon: 'success',title: msg})
        });
        window.livewire.on('empleado-deleted',msg => {
            Toast.fire({icon: 'success',title: msg})
        });
    });
    function ingresar_dias_facturas(id){
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
