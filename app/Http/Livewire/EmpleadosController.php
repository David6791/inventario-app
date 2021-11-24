<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Empleados;
use App\Models\Cargos;

class EmpleadosController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $fecha_contratacion,$ci,$customFileName,$profile, $cargo,$nombres, $apellidos, $telefono, $direccion, $email, $status, $image,$selected_id,$fileLoaded,$role,$pageTitle, $componentName,$search;
    private $pagination = 10;
    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Empleados';
        $this->status = 'Elegir';
        $this->cargo = 'Elegir';
    }
    public function paginationView(){
        return 'vendor.livewire.bootstrap';
    }
    public function render()
    {
        if(strlen($this->search) > 0){
            $data = Empleados::where('nombres','like','%'.$this->search.'%')
                    ->select('*','empleados.id as id_em','c.nombre_cargo','c.id as id_cargo')->join('cargos as c', 'c.id','empleados.cargo')->orderBy('empleados.id','asc')->paginate($this->pagination);
        }else{
            $data = Empleados::select('*','empleados.id as id_em','c.nombre_cargo','c.id as id_cargo')->join('cargos as c', 'c.id','empleados.cargo')->orderBy('empleados.id','asc')->paginate($this->pagination);
        }
        return view('livewire.empleados.component',[
            'data' => $data,
            'cargos' => Cargos::orderBy('nombre_cargo','asc')->get(),
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    public function crearEmpleados(){
        $rules = [
            'nombres' => 'required|min:3',
            'apellidos' => 'required|min:3',
            'cargo' => 'required',
            'telefono' => 'required',
            'email' => 'required|unique:users|email',
            'ci' => 'required|unique:users,ci',
            'status' => 'required|not_in:Elegir',
            'direccion' => 'required',
            'fecha_contratacion' => 'required',
        ];
        $messages = [
            'nombres.required' => 'Ingrese el Nombre',
            'nombres.min' => 'El Nombre de Usuario debe tener al menos 3 caracteres.',
            'apellidos.required' => 'Ingrese los Apellidos',
            'apellidos.min' => 'Los Apellidos deben tener al menos 3 caracteres.',
            'email.required' => 'Ingrese el emailsada',
            'email.unique' => 'El email ingresado ya esta en uso.',
            'email.email' => 'hola perra',
            'ci.required' => 'La Cedula de Identidad es requerida',
            'ci.unique' => 'La Cedula de Identidad ingresada ya esta en uso',
            'status.required' => 'Seleccione un estado.',
            'telefono.required' => 'Ingrese un Telefono..',
            'status.not_in' => 'Seleccione un estado diferente.',
            'direccion.required' => 'Debe Ingresar una direccion.',
            'cargo.required' => 'Debe Ingresar el Cargo de Este Empleado.',
            'fecha_contratacion.required' => 'Debe Ingresar la Fecha de Contratacion del Empleado.',
        ];
        $this->validate($rules,$messages);
        $user = Empleados::create([
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'email' => $this->email,
            'ci' => $this->ci,
            'telefono' => $this->telefono,
            'profile' => 'EMPLEADO',
            'direccion' => $this->direccion,
            'cargo' => $this->cargo,
            'fecha_contratacion' => $this->fecha_contratacion
        ]);
        if($this->image){
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/empleados',$customFileName);
            $user->image = $customFileName;
            $user->save();
        }
        $this->resetUI();
        $this->emit('empleado-added','Empleado registrado exitosamente');
    }
    public function Edit_empleados(Empleados $empleado){
        $this->selected_id = $empleado->id;
        $this->nombres = $empleado->nombres;
        $this->apellidos = $empleado->apellidos;
        $this->ci = $empleado->ci;
        $this->telefono = $empleado->telefono;
        $this->profile = $this->profile;
        $this->status = $empleado->status;
        $this->email = $empleado->email;
        $this->direccion = $empleado->direccion;
        $this->cargo = $empleado->cargo;
        $this->fecha_contratacion = $empleado->fecha_contratacion;
        $this->emit('show-modal','open');
    }
    public function actualizar(){
        $rules = [
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'nombres' => 'required|min:3',
            'direccion' => 'required',
            'cargo' => 'required',
            'fecha_contratacion' => 'required',
            'apellidos' => 'required|min:3',
            'status' => 'required|not_in:Elegir',
            'ci' => "required|unique:users,ci,{$this->selected_id}",
        ];
        $messages = [
            'nombres.required' => 'Ingrese el Nombre',
            'nombres.min' => 'El Nombre de Usuario debe tener al menos 3 caracteres.',
            'apellidos.required' => 'Ingrese Los Apellidos',
            'apellidos.min' => 'Los Apellidos deben tener al menos 3 caracteres.',
            'email.required' => 'Ingrese el emailsdssssss',
            'email.unique' => 'El email ingresado ya esta en uso.',
            'status.required' => 'Seleccione un estado.',
            'status.not_in' => 'Seleccione un estado diferente.',
            'ci.required' => 'La Cedula de Identidad es requerida',
            'ci.unique' => 'La Cedula de Identidad ingresada ya esta en uso',
            'direccion.required' => 'Ingrese la Direccion del Empleado',
            'cargo.required' => 'Seleccione el Cargo del Empleado',
            'fecha_contratacion.required' => 'Ingrese la Fecha de Contratacion',
        ];
        $this->validate($rules,$messages);
        $empleado = Empleados::find($this->selected_id);
        $empleado->update([
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'email' => $this->email,
            'ci' => $this->ci,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'status' => $this->status,
            'cargo' => $this->cargo,
            'fecha_contratacion' => $this->fecha_contratacion,
        ]);
        if($this->image){
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/empleados',$customFileName);
            $imageTemp = $empleado->image;
            $empleado->image = $customFileName;
            $empleado->save();
            if($imageTemp != null){
                if(file_exists('storage/empleados/'.$imageTemp)){
                    unlink('storage/empleados/'.$imageTemp);
                }
            }
        }
        $this->resetUI();
        $this->emit('empleado-updated','Datos de Empleado actualizados exitosamente');
    }
    protected $listeners = [
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI',
        'baja_empleado' => 'baja_empleado_function'
    ];
    public function destroy(Empleados $empleado){
        if($empleado){
            /*$sales = Sale::where('user_id',$user->id)->count();
            if($sales > 0){
                $this->emit('user-withsales','No se puede eliminar este Usuario por que tiene ventas registradas.');
            }else{*/
                $empleado->delete();
                $this->resetUI();
                $this->emit('empleado-deleted','Datos de Empleado eliminado correctamente.');
            //}
        }
    }
    public function resetUI(){
        $this->resetValidation();
        $this->nombres='';
        $this->apellidos='';
        $this->ci='';
        $this->telefono='';
        $this->email='';
        $this->direccion='';
        $this->image='';
        $this->search='';
        $this->status='';
        $this->cargo='';
        $this->fecha_contratacion='';
        $this->selected_id='';
        //para poder volver al indice de la pagina
        $this->resetPage();
    }
    public function baja_empleado_function(Empleados $empleado){
        if($empleado->status === 'ACTIVE'){
            $empleado->update([
                'status' => 'LOCKED',
            ]);
            $this->resetUI();
            $this->emit('empleado-activo','El Empleado se dio de Baja correctamente.');
        }else{
            $empleado->update([
                'status' => 'ACTIVE',
            ]);
            $this->resetUI();
            $this->emit('empleado-bajas','El Empleado se Habilito correctamente.');
        }
    }
}
