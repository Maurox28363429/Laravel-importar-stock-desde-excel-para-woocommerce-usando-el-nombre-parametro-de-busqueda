<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class puestos extends Model
{
    use HasFactory;
    protected $fillable=[
        "evento_id",
        "disponible"
    ];
    public function evento(){
        return $this->belongsTo(eventos::class);
    }
}
