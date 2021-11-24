<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Areas;
use App\Models\Departamento;

class AreaController extends Component
{
    use WithPagination;
    public $search,$componentName,$pageTitle,$selected_id;
    private $pagination = 10;
    public function paginationView(){
        return 'vendor.livewire.bootstrap';
    }

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Areas';
    }
    public function render()
    {
        if(strlen($this->search) > 0)
            $areas = Areas::where('name','like','%'.$this->search.'%')->paginate($this->pagination);
        else
            $areas = Areas::orderby('name','asc')->paginate($this->pagination);
        return view('livewire.areas.component',[
            'areas' => $areas,
            'categories' => Departamento::orderby('id','asc')->get(),
        ])->extends('layouts.theme.app')
        ->section('content');
    }
    public function load_productss($id){
        dd("sadsadsadsadasd");
    }
}
