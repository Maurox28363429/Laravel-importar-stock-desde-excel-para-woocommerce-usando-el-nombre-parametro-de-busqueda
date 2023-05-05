<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{
    eventos,
    puestos,
    ticket
};
class PuestosController extends Controller
{
    public function index($id,Request $request){
        $puestos=puestos::where('evento_id',$id)->get();
        return response()->json([
            'message' => 'Puestos del evento',
            'data' => $puestos
        ], 200);
    }
    public function update($id,Request $request){
        try {
            $data=$request->all();
            if($data['disponible']==false){
                $ticket=ticket::where('puesto_id',$id)->delete();
                $puesto = puestos::find($id);
                $puesto->disponible = !$data['disponible'];
                $puesto->save();
                return response()->json([
                    'message' => 'Puesto disponible',
                    'data' => $puesto
                ], 200);
            }
            $puesto=puestos::find($id);
            $puesto->disponible=!$data['disponible'];
            $puesto->save();
            $ticket=ticket::create([
                'evento_id'=>$puesto->evento_id,
                'puesto_id'=>$puesto->id,
                'nombre'=>$request->input('nombre') ?? 'Anonimo',
                'metodo_pago'=>'efectivo'
            ]);
            return response()->json([
                'message' => ($data['disponible'])?'Puesto disponible':'Puesto ocupado',
                'data' => $ticket
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al ocupar el puesto',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
