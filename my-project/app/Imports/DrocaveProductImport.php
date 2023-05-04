<?php

namespace App\Imports;

use App\Models\datos;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Http;

class DrocaveProductImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       //
       $domain="https://drocave.com/wp-json/wc/v3/";
       $consumer_key="ck_6abbef393f828ea5c7d145e089a43f1c094fc33c";
       $consumer_secret="cs_d76f7eaf109f116c873e4c5c6b7b1fd0f8f34a44";

        $response = Http::get('https://jsonplaceholder.typicode.com/users');

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . base64_encode($consumer_key.':'.$consumer_secret),
        ])->get($domain.'products?search='.$row['descripcion']);

        if($response->ok()) {
            $data = $response->json();
            $product_id=$data[0]['id'];
            $response2 = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($consumer_key.':'.$consumer_secret),
            ])->asForm()->put($domain."products/{$product_id}", [
                'stock_quantity' => $row['stock'],
                'price' => $row['pvp'],

            ]);
            // Do something with the response data
        } else {
            // Handle the error response
            $data=[];
        }
        //return new datos([
            //
        //]);
    }
}
