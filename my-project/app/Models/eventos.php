<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    puestos,
    ticket
};
class eventos extends Model
{
    use HasFactory;
    protected $fillable=[
        "nombre",
        "descripcion",
        "lugar",
        "precio",
    ];
    public function puestos(){
        return $this->hasMany(puestos::class);
    }
    public function tickets(){
        return $this->hasMany(ticket::class);
    }
    //getters
    protected $appends = ['puestos_disponibles','puestos_ocupados','puestos_totales'];
    public function getPuestosDisponiblesAttribute(){
        return puestos::query()->where('evento_id', $this->id)->where('disponible',true)->count();
    }
    public function getPuestosOcupadosAttribute(){
        return puestos::query()->where('evento_id', $this->id)->where('disponible',false)->count();
    }
    public function getPuestosTotalesAttribute(){
        return puestos::query()->where('evento_id',$this->id)->count();
    }
    public function getCreatedAtAttribute()
    {
        $date = explode(" ", $this->attributes['created_at']);
        $fecha = $date[0];
        $time = $date[1];
        $fecha = explode("-", $fecha);
        return $fecha = $fecha["2"] . "/" . $fecha["1"] . "/" . $fecha["0"];
    }
}
