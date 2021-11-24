<div class="row titulo">
    <div class="col-md-12">
        <center>
            <h3>Laboratorio de Análisis Químico LABSOLIS</h3>
            <h3 class="titulo-arriba">PLANILLA DE SUELDOS Y SALARIOS</h3>
        </center>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <p>Correspondiente al Mes de: {{ $nombre_mes->nombre_mes }} del Año: {{$nombre_year->nombre_year}} </p>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table_leters table">
            <thead>
                <tr>
                    <th colspan="7"></th>
                    <th colspan="5">DESCUENTOS</th>
                    <th colspan="2"></th>
                </tr>
            </thead>
            <thead>
                <tr>
                    <th>Nro.</th>
                    <th>NOMBRES Y APELLIDOS</th>
                    <th>CARGO</th>
                    <th>HABER BASICO</th>
                    <th>FECHA DE INGRESO</th>
                    <th>BONO ANTIGUEDAD</th>
                    <th>TOTAL GANADO</th>
                    <th>AFP 10%</th>
                    <th>RIESGO COMUN 1.17%</th>
                    <th>COMISIONES 0.005%</th>
                    <th>APORTE SOLIDARIO 0.005%</th>
                    <th>RC-IVA</th>
                    <th>TOTAL DESCUENTOS</th>
                    <th>LIQUIDO PAGABLE</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $a=1
                ?>
                @foreach ($data as $d)
                    <tr>
                        <td>{{$a++}}</td>
                        <td>{{$d->nombres}} {{ $d->apellidos}}</td>
                        <td>{{$d->nombre_cargo}}</td>
                        <td>{{$d->haber_basico}}</td>
                        <td>{{$d->fecha_contratacion}}</td>
                        <td>{{$d->bono_antiguedad}}</td>
                        <td>{{$d->total_ganado}}</td>
                        <td>{{$d->afp}}</td>
                        <td>{{$d->anticipos}}</td>
                        <td>{{$d->extras}}</td>
                        <td>{{$d->aporte_solidario}}</td>
                        <td>{{$d->iva}}</td>
                        <td>{{$d->descuentos}}</td>
                        <td>{{$d->liquido_pagable}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>

    .table_leters, .table_leters tr, .table_leters tr th, .table_leters tbody tr td{
        border: 1px solid #000;
    }

.table_leters{
    font-size: 10px;
}
.titulo{
    margin-top: -40px;
}
.titulo-arriba{
    margin-top: -15px;
}
</style>
