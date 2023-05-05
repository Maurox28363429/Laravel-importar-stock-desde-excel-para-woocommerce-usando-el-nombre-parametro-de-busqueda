<?php

namespace App\Http\Controllers;

use App\Models\{
    eventos,
    puestos,
    ticket
};
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class EventosController extends Controller
{
    public function store(Request $request){
        try {
            DB::beginTransaction();
                $query = eventos::query();
                $data = $request->all();
                $evento=$query->create($data);
                if($data['filas'] && $data['columnas']){
                    $generador=$data['filas']*$data['columnas'];
                    for($i=0;$i<$generador;$i++){
                        puestos::create([
                            'evento_id'=>$evento->id,
                            'disponible'=>true
                        ]);
                    }
                }
            DB::commit();
            return response()->json([
                'message' => 'Evento creado correctamente',
                'data' => $data
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error al crear el evento',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
