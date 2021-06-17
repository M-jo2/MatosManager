<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerEquipment;
use App\Http\Controllers\ControllerPerson;
use App\Http\Controllers\ControllerRoom;
use App\Http\Controllers\ControllerAssignation;
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

Route::get('/equipment',[ControllerEquipment::class,'index'])->name('equipment.index');
Route::get('/equipment/deleteofficestuff/{id}',[ControllerEquipment::class,'deleteOfficeStuff'])->name('equipment.deleteOfficeStuff');
Route::get('/equipment/deletecomputerstuff/{id}',[ControllerEquipment::class,'deleteComputerStuff'])->name('equipment.deleteComputerStuff');
Route::post('/equipment',[ControllerEquipment::class,'create'])->name('equipment.addEquipment');
Route::get('/equipment/edit/{idstuff}/{type}',[ControllerEquipment::class,'edit'])->name('equipment.edit');
Route::post('/equipment/update',[ControllerEquipment::class,'update'])->name('equipment.update');
Route::get('/equipment/download/officestuff',[ControllerEquipment::class,'exportCsvOfficeStuff'])->name('equipment.download');

Route::get('/person',[ControllerPerson::class,'index'])->name('person.index');
Route::get('/person/delete/{id}',[ControllerPerson::class,'delete'])->name('person.delete');
Route::post('/person',[ControllerPerson::class,'create'])->name('person.addPerson');


Route::get('/room',[ControllerRoom::class,'index'])->name('room.index');
Route::get('/room/delete/{id}',[ControllerRoom::class,'delete'])->name('room.delete');
Route::post('/room',[ControllerRoom::class,'create'])->name('room.addRoom');


Route::get('/assign/OfficeStuff/{id}',[ControllerAssignation::class,'assignOfficeStuff'])->name('assign.OfficeStuff');
Route::get('/assign/ComputerStuff/{id}',[ControllerAssignation::class,'assignComputerStuff'])->name('assign.ComputerStuff');
Route::get('/assign/Person/{id}',[ControllerAssignation::class,'assignPerson'])->name('assign.Person');
Route::get('/assign/Room/{id}',[ControllerAssignation::class,'assignRoom'])->name('assign.Room');
Route::get('/assign/delete/{type}/{id}',[ControllerAssignation::class,'delete'])->name('assign.delete');
Route::post('/assign',[ControllerAssignation::class,'save'])->name('assign.save');



Route::get('/', function () {
    return redirect()->route('equipment.index');
});

Route::get('/welcome', function () {
    return view('welcome');
});
