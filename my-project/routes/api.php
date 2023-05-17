<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Imports\DrocaveProductImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/eventos', "App\Http\Controllers\EventosController@store");
Route::get('/puestos/{id}', "App\Http\Controllers\PuestosController@index");
Route::put('/ocupar/{id}', "App\Http\Controllers\PuestosController@update");
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/import', function (Request $request) {
    $file = $request->file('file');
    return Excel::import(new DrocaveProductImport, $file);
});

Route::get('/import2',function(){
    // Get the full path to the JSON file
    $jsonFilePath = public_path('web.json');

    // Load the contents of the JSON file
    $jsonString = file_get_contents($jsonFilePath);

    // Decode the JSON string into a PHP array
    $web = collect(
        json_decode($jsonString, true)
    );

    // Get the full path to the JSON file
    $jsonFilePath2 = public_path('ibram.json');

    // Load the contents of the JSON file
    $jsonString2 = file_get_contents($jsonFilePath2);

    // Decode the JSON string into a PHP array
    $excel = json_decode($jsonString2, true);

    $domain = "https://drocave.com/wp-json/wc/v3/";
    $consumer_key = "ck_6abbef393f828ea5c7d145e089a43f1c094fc33c";
    $consumer_secret = "cs_d76f7eaf109f116c873e4c5c6b7b1fd0f8f34a44";
    $web=collect(
        $web->map(function($value){
            return [
                'ID'=>$value["ID"],
                "post_title"=>$value['post_title']
            ];
        })
    );
    foreach($excel as $row){
        $nombre=$row['nombre'];
        $product = $web->filter(function ($value2, $key)use($nombre,$domain,$consumer_key,$consumer_secret,$row)
        {
            return $value2['post_title'] == $nombre;
        })->values()->first();
        if($product && $product['ID']){
            $response4 = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($consumer_key . ':' . $consumer_secret),
            ])->asForm()->put($domain . "products/{$product['ID']}", [
                'stock_quantity' => $row['stock'],
                'price' => $row['pvp'],
            ]);
        }
    }
});
