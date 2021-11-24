<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\RolesController;
use App\Http\Livewire\PermisosController;
use App\Http\Livewire\AsignarController;
use App\Http\Livewire\UsersController;
use App\Http\Livewire\EmpleadosController;
use App\Http\Livewire\PlanillasController;
use App\Http\Livewire\PlanillasIvaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'),


    Route::get('roles', RolesController::class),
    Route::get('usuarios', UsersController::class),
    Route::get('permisos', PermisosController::class),
    Route::get('asignar', AsignarController::class),
    Route::get('empleados', EmpleadosController::class),
    Route::get('planillas', PlanillasController::class),
    Route::get('planillas_iva', PlanillasIvaController::class),




    //rutas para reportes
    Route::get('report_planilla_sueldos/{year}/{mes}',[App\Http\Livewire\PlanillasController::class, 'report_planilla_sueldos'])->name('report_planilla_sueldos'),
]);
