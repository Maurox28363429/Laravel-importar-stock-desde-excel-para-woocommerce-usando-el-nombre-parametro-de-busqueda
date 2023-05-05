<?php

use Illuminate\Support\Facades\Route;
use App\Models\{
    eventos,
    puestos,
    ticket
};
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/eventos', function () {
    return view('eventos',[
        'eventos'=>eventos::paginate(15)
    ]);
});

Route::get('/eventos/destroy', function (Request $request) {
    $id=$request->id;
    ticket::query()->where("evento_id",$id)->delete();
    puestos::query()->where("evento_id", $id)->delete();
    eventos::find($id)->delete();
    return view('eventos', [
        'eventos' => eventos::paginate(15)
    ]);
})->name("eventos.destroy");

Route::get('puestos', function (Request $request) {
    $id=$request->id;
    return view('puestos',[
        'puestos'=>puestos::query()->where("evento_id",$id)->get()
    ]);
})->name('puestos');
Route::get('mau',function(){
    return 10;
});
