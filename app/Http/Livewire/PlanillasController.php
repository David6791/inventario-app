<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Planillas;
use App\Models\Years;
use App\Models\Meses;
use App\Models\Empleados;

class PlanillasController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $listas_empleados=[];
    public $ci,$customFileName,$profile, $year, $mes,$nombre_year, $nombre_mes, $nombres, $apellidos, $telefono, $direccion, $email, $status, $image,$selected_id,$fileLoaded,$role,$pageTitle, $componentName,$search;
    private $pagination = 10;
    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Planilla de Sueldos y Salarios';
    }
    public function paginationView(){
        return 'vendor.livewire.bootstrap';
    }
    public function render()
    {
        if(strlen($this->search) > 0){
            $data = Planillas::where('nombres','like','%'.$this->search.'%')
                    ->select('*')->orderBy('id','asc')->paginate($this->pagination);
        }else{
            $data = Planillas::select('*')->orderBy('id','asc')->paginate($this->pagination);
        }
        return view('livewire.planillas.component',[
            'years' => Years::orderBy('id','asc')->get(),
            'meses' => Meses::orderBy('id','asc')->get(),
        ])->extends('layouts.theme.app')
        ->section('content');
    }
    public function cargar_datos_planilla(){
        $this->resetUI();
        $date = Years::where('id','=',$this->year)->first();
        $this->nombre_year = $date->nombre_year;
        $month = Meses::where('id','=',$this->mes)->first();
        $this->nombre_mes = $month->nombre_mes;
        $listas = Planillas::where('id_year','=',$this->year)->where('id_mes','=',$this->mes)->get();
        if(count($listas) === 0){
            $lista_empleados = Empleados::where('status','=','ACTIVE')->get();
            $cant = count($lista_empleados);
            for($i = 0; $i < $cant; $i++){
                \DB::table('planillas')->insert([
                    'id_empleado' => $lista_empleados[$i]->id,
                    'dias_trabajados' => '0',
                    'haber_basico' => '0',
                    'bono_antiguedad' => '0',
                    'nocturnos' => '0',
                    'total_ganado' => '0',
                    'afp' => '0',
                    'iva' => '0',
                    'extras' => '0',
                    'anticipos' => '0',
                    'faltas_sanciones' => '0',
                    'descuentos' => '0',
                    'liquido_pagable' => '0',
                    'id_mes' => $this->mes,
                    'id_year' => $this->year
                ]);
            }
        }
        $this->listas_empleados = Planillas::join('empleados as e', 'e.id', 'planillas.id_empleado')
                                            ->join('cargos as c', 'c.id', 'e.cargo')
                                            ->where('id_year','=',$this->year)->where('id_mes','=',$this->mes)
                                            ->get([
                                                'e.nombres','e.apellidos','e.cargo','e.id as id_empleado',
                                                'c.nombre_cargo','c.haber_basico',
                                                'planillas.finalizado','planillas.aporte_solidario','planillas.id as id_planilla','planillas.dias_trabajados','planillas.bono_antiguedad','planillas.nocturnos','planillas.total_ganado','planillas.afp','planillas.iva','planillas.anticipos','planillas.faltas_sanciones','planillas.descuentos','planillas.liquido_pagable','planillas.extras',
                                            ]);

    }
    public function resetUI(){
        $this->resetValidation();
        $this->listas_empleados=[];

        //para poder volver al indice de la pagina
        $this->resetPage();
    }
    protected $listeners = [
        'agregar_dias_trabajados' => 'agregar_dias_trabajados_tabla',
        'quitar_empleado_planillas' => 'quitar_empleado_planilla_function',
        'fin_planilla' => 'fin_planilla_function'
    ];
    public function agregar_dias_trabajados_tabla($id, $dias){
        $firstDate  = date("Y",strtotime(now()));
        $date = Planillas::find($id);
        $secondDate = Empleados::join('cargos as c','c.id','empleados.cargo')->where('empleados.id','=',$date->id_empleado)->get(['empleados.fecha_contratacion','c.haber_basico'])->first();
        $s = date("Y",strtotime($secondDate->fecha_contratacion));
        $dif = $firstDate - $s;
        $hb =  $secondDate->haber_basico;
        $ba = $this->antiguedad($dif);
        $bna = (1*2164)*$ba;
        $tg = $hb+$bna;
        $afp = $tg*0.10;
        $riegocomun = $tg*0.0171;
        $comisiones = $tg*0.005;
        $aporte_solidario = $tg*0.005;
        $descuentos = $afp+$riegocomun+$comisiones+$aporte_solidario+$date->iva;
        $liquido_pagable = $tg-$descuentos;

        //Para las formulas de IVA
        $minimo_imponible = 2164*2;
        $diferencia_sueldo = $liquido_pagable-$minimo_imponible;
        $impuestos = $diferencia_sueldo*0.13;
        $orm110 = $secondDate->facturas_presentadas*0.13;
        $dossalarios_minimos = (2164*2)*0.13;
        $impuestos_netos = 0;
        if($impuestos > $dossalarios_minimos){
            $impuestos_netos = $impuestos - $dossalarios_minimos;
        }else{
            $impuestos_netos = 0;
        }
        $descuentos = $afp+$riegocomun+$comisiones+$aporte_solidario+$impuestos_netos;
        $liquido_pagable = $tg-$descuentos;
        $affected = \DB::table('planillas')
              ->where('id', $id)
              ->update([
                    'dias_trabajados' => $dias,
                    'haber_basico' => $secondDate->haber_basico,
                    'bono_antiguedad' => $bna,
                    'total_ganado' => $tg,
                    'afp' => $afp,
                    //riesgo Comun = anticipos
                    'anticipos' => $tg*0.0171,

                    //comisiones = extras
                    'extras' => $tg*0.005,

                    //Comisiones  =
                    'nocturnos' => $tg*0.005,

                    'aporte_solidario' => $aporte_solidario,
                    //arreglar iva de acuerdo a las formulas
                    'iva' => $impuestos_netos,
                    'descuentos' => $descuentos,
                    'liquido_pagable' => $tg-$descuentos,

                ]);

        $this->listas_empleados = Planillas::join('empleados as e', 'e.id', 'planillas.id_empleado')
                                            ->join('cargos as c', 'c.id', 'e.cargo')
                                            ->where('id_year','=',$this->year)->where('id_mes','=',$this->mes)
                                            ->get([
                                                'e.nombres','e.apellidos','e.cargo','e.id as id_empleado',
                                                'c.nombre_cargo','c.haber_basico',
                                                'planillas.finalizado','planillas.aporte_solidario','planillas.id as id_planilla','planillas.dias_trabajados','planillas.bono_antiguedad','planillas.nocturnos','planillas.total_ganado','planillas.afp','planillas.iva','planillas.anticipos','planillas.faltas_sanciones','planillas.descuentos','planillas.liquido_pagable','planillas.extras',
                                            ]);
        $this->emit('actualizado_salario','Datos de la Planilla Actualizado Correctamente');
    }
    public function quitar_empleado_planilla_function(Planillas $empleado){
            $year = $empleado->id_year;
            $mes = $empleado->id_mes;
            $empleado->delete();
            $this->resetUI();
            $this->listas_empleados = Planillas::join('empleados as e', 'e.id', 'planillas.id_empleado')
                                            ->join('cargos as c', 'c.id', 'e.cargo')
                                            ->where('id_year','=',$year)->where('id_mes','=',$mes)
                                            ->get([
                                                'e.nombres','e.apellidos','e.cargo','e.id as id_empleado',
                                                'c.nombre_cargo','c.haber_basico',
                                                'planillas.finalizado','planillas.aporte_solidario','planillas.id as id_planilla','planillas.dias_trabajados','planillas.bono_antiguedad','planillas.nocturnos','planillas.total_ganado','planillas.afp','planillas.iva','planillas.anticipos','planillas.faltas_sanciones','planillas.descuentos','planillas.liquido_pagable','planillas.extras',
                                            ]);
            $this->emit('empleado-deleted','Empleado eliminado de la Planilla Correctamente.');
    }
    protected function antiguedad($dif){
        //=SI(F13<2,"0%",SI(F13<5,"5%",SI(F13<8,"11%",SI(F13<11,"18%",SI(F13<15,"26%",SI(F13<20,"34%",SI(F13<25,"42%",SI(F13>=25,"50%"))))))))
        if($dif > 0 and $dif < 2)
            return 0;
        if($dif >= 3 and $dif < 5)
            return 0.05;
        if($dif >= 5 and $dif < 8)
            return 0.11;
        if($dif >= 9 and $dif < 11)
            return 0.18;
        if($dif >= 12 and $dif < 15)
            return 0.26;
        if($dif >= 16 and $dif < 20)
            return 0.34;
        if($dif >= 21 and $dif < 25)
            return 0.42;
        if($dif >= 25)
            return 0.50;
    }
    public function fin_planilla_function(){
        $affected = \DB::table('planillas')
        ->where('id_year', $this->year)
        ->where('id_mes', $this->mes)
        ->update([
            'finalizado' => 1
          ]);
    }
    public function report_planilla_sueldos($year,$mes){
        setlocale(LC_ALL, 'es_ES');
        //$fecha = new \Carbon\Carbon::parse('03-04-2018');
        //$fecha->format("F"); // Inglés.
        //$mes = $fecha->formatLocalized('%B');// mes en idioma español
        //$carbon = new \Carbon\Carbon();
        //$dat = $date->formatLocalized(' jS \\of F Y ');
        $nombre_year = Years::find($year);
        $nombre_mes = Meses::find($mes);
        $data = Planillas::join('empleados as e', 'e.id', 'planillas.id_empleado')
                                            ->join('cargos as c', 'c.id', 'e.cargo')
                                            ->where('id_year','=',$year)->where('id_mes','=',$mes)
                                            ->get([
                                                'e.nombres','e.apellidos','e.cargo','e.id as id_empleado','e.fecha_contratacion',
                                                'c.nombre_cargo','c.haber_basico',
                                                'planillas.finalizado','planillas.aporte_solidario','planillas.id as id_planilla','planillas.dias_trabajados','planillas.bono_antiguedad','planillas.nocturnos','planillas.total_ganado','planillas.afp','planillas.iva','planillas.anticipos','planillas.faltas_sanciones','planillas.descuentos','planillas.liquido_pagable','planillas.extras',
                                            ]);
        //return $sd->formatLocalized(' %d de %B del %Y');
            return \PDF::loadView('livewire.planillas.planilla_sueldos',compact('data','nombre_mes','nombre_year'))->setPaper('a4', 'landscape')->stream('planilla_sueldos.pdf');

    }
    private function year_data(){
        return $this->year;
    }

}
