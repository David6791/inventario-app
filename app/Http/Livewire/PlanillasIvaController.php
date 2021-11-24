<?php

namespace App\Http\Livewire;

use Livewire\Component;

use Livewire\WithPagination;
use Livewire\WithFileUploads;

use App\Models\Years;
use App\Models\Meses;
use App\Models\Planillas;
use App\Models\Empleados;

class PlanillasIvaController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $listas_empleados=[];
    public $pageTitle, $componentName,$nombre_year, $nombre_mes,$year, $mes, $impuestos_control;

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'PLANILLA IMPOSITIVA DEL RC - IVA ';
    }

    public function paginationView(){
        return 'vendor.livewire.bootstrap';
    }

    public function render()
    {
        return view('livewire.planillas_iva.component',[
            'years' => Years::orderBy('id','asc')->get(),
            'meses' => Meses::orderBy('id','asc')->get(),
        ])->extends('layouts.theme.app')
        ->section('content');
    }
    public function cargar_datos_planilla_iva(){
        $this->resetUI();
        $date = Years::where('id','=',$this->year)->first();
        $this->nombre_year = $date->nombre_year;
        $month = Meses::where('id','=',$this->mes)->first();
        $this->nombre_mes = $month->nombre_mes;
        $listas = Planillas::where('id_year','=',$this->year)->where('id_mes','=',$this->mes)->get();

        $this->impuestos_control = Planillas::where('id_year','=',$this->year)->where('id_mes','=',$this->mes)->get(['impuestos_control'])->first();

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
        'agregar_dias_trabajados' => 'ingresar_dias_facturas'
    ];
    public function ingresar_dias_facturas($id,$val){
        $date = Planillas::find($id);
        $secondDate = Empleados::join('cargos as c','c.id','empleados.cargo')->where('empleados.id','=',$date->id_empleado)->get(['empleados.fecha_contratacion','c.haber_basico'])->first();
        $firstDate  = date("Y",strtotime(now()));
        $s = date("Y",strtotime($secondDate->fecha_contratacion));
        $dif = $firstDate - $s;

        //minimo no imponible
        $minimo_no_imponible = $date->salario_minimo;

        $dif_base_imponible = $date->liquido_pagable-$minimo_no_imponible;

        $impuesto = $dif_base_imponible*0.13;

        $form = $val*0.13;

        $salario_minimo_trece = (2164*2)*0.13;

        if(($impuesto-$salario_minimo_trece) > 0){
            $impuesto_neto = $impuesto-$salario_minimo_trece;
        }else{
            $impuesto_neto = 0;
        }
        if($impuesto>($form+$salario_minimo_trece)){
            $fisco = $impuesto-$form-$salario_minimo_trece;
        }else{
            $fisco = 0;
        }
        if(($form-$impuesto_neto)>0){
            $dependiente = $form-$impuesto_neto;
        }else{
            $dependiente = 0;
        }

        $mant_de_valor = $date->saldo_f_per_anterior*((2.365668/2.363118)-1);

        $saldo_act = $date->saldo_f_per_anterior+$mant_de_valor;

        $saldo_favor = $dependiente+$saldo_act;

        if(($fisco-$date->saldo_utilizado)>$date->saldo_utilizado){
        $impuesto_retenido = 0-$fisco;
        }else{
            $impuesto_retenido = 0;
        }

        $saldo_sig_mes = $date->saldo_utilizado-$saldo_favor;
        $affected = \DB::table('planillas')
              ->where('id', $id)
              ->update([
                    'facturas_presentadas' => $val,
                    'minimo_no_imponible' => $minimo_no_imponible,
                    'diferencia_base_imponible' => $dif_base_imponible,
                    'iva_reducido' => $impuesto,
                    'form110' => $form,
                    'salario_minimo' => $salario_minimo_trece,
                    'impuesto_neto' => $impuesto_neto,
                    'fisco' => $fisco,
                    'dependiente' => $dependiente,
                    'saldo_f_per_anterior' => 0,
                    'mantenimiento_valor' => $mant_de_valor,
                    'saldo_actualizado' => $saldo_act,
                    'saldo_favor' => $saldo_favor,
                    'saldo_utilizado' => 0,
                    'impuesto_retenido' => $impuesto_retenido,
                    'saldo_siguiente_mes' => $saldo_sig_mes,
                ]);

        $this->listas_empleados = Planillas::join('empleados as e', 'e.id', 'planillas.id_empleado')
        ->join('cargos as c', 'c.id', 'e.cargo')
        ->where('id_year','=',$this->year)->where('id_mes','=',$this->mes)
        ->get([
            'e.nombres','e.apellidos','e.cargo','e.id as id_empleado',
            'c.nombre_cargo','c.haber_basico',
            'planillas.liquido_pagable',
            'planillas.minimo_no_imponible',
            'planillas.diferencia_base_imponible',
            'planillas.iva_reducido',
            'planillas.form110',
            'planillas.salario_minimo',
            'planillas.impuesto_neto',
            'planillas.fisco',
            'planillas.saldo_f_per_anterior',
            'planillas.mantenimiento_valor',
            'planillas.saldo_actualizado',
            'planillas.saldo_favor',
            'planillas.saldo_utilizado',
            'planillas.impuesto_retenido',
            'planillas.saldo_siguiente_mes',

            'planillas.dependiente','planillas.facturas_presentadas','planillas.finalizado','planillas.aporte_solidario','planillas.id as id_planilla','planillas.dias_trabajados','planillas.bono_antiguedad','planillas.nocturnos','planillas.total_ganado','planillas.afp','planillas.iva','planillas.anticipos','planillas.faltas_sanciones','planillas.descuentos','planillas.liquido_pagable','planillas.extras',
        ]);
        $this->emit('actualizado_impuestos','Datos de la Planilla Actualizado Correctamente');
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
}
