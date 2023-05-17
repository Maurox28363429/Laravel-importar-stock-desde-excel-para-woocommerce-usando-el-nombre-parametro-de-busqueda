<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use PSpell\Config;
use Psy\Readline\Hoa\Console;

class resetearProductosDrocaveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:resetear-productos-drocave-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $domain = "https://drocave.com/wp-json/wc/v3/";
        $consumer_key = "ck_6abbef393f828ea5c7d145e089a43f1c094fc33c";
        $consumer_secret = "cs_d76f7eaf109f116c873e4c5c6b7b1fd0f8f34a44";
        // Get the full path to the JSON file
        $jsonFilePath2 = public_path('csvjson.json');

        // Load the contents of the JSON file
        $jsonString2 = file_get_contents($jsonFilePath2);

        // Decode the JSON string into a PHP array
        $excel = json_decode($jsonString2, true);
        $noEncontrados = [];
        $noActualizados=[];
        foreach ($excel as $key => $value) {
            $this->line($value["nombre"]);
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($consumer_key . ':' . $consumer_secret),
            ])->get($domain . 'products?search=' .$value['nombre']);

            if ($response->successful()) {
                $data = $response->json();
                if(count($data)==0){
                    $noEncontrados[]=$value;
                    $this->line("____________No se encontro el producto " . $value["nombre"]);
                    continue;
                }
                $product_id = $data[0]['id'];
                $this->line("Busqueda exitosa ID=" . $product_id . " " . $value["nombre"]);
            } else {
                $noEncontrados[] = $value;
                continue;
            }
            $response2 = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($consumer_key . ':' . $consumer_secret),
            ])->asForm()->put($domain . "products/{$product_id}", [
                'stock_quantity' => $value['stock'],
                'price' => $value['pvp'],
            ]);
            if($response2->successful()){
                $this->line("Actualizacion exitosa ID=" . $product_id . " " . $value["nombre"]);
            }else{
                $noActualizados[]=$value;
                $this->line("____________Actualizacion fallida ID=" . $product_id . " " . $value["nombre"]);
            }
        }
        $this->line("No encontrados----------------");
        $this->line(json_encode($noEncontrados));
        $this->line("No actualizados----------------");
        $this->line(json_encode($noActualizados));

    }
}
