<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ticket extends Model
{
    use HasFactory;
    protected $fillable=[
        "evento_id",
        "puesto_id",
        "nombre",
        "metodo_pago"
    ];
    public function evento(){
        return $this->belongsTo(eventos::class);
    }
    public function puesto(){
        return $this->belongsTo(puestos::class);
    }
}
