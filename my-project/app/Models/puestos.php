<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    eventos,
    ticket
};
class puestos extends Model
{
    use HasFactory;
    protected $fillable=[
        "evento_id",
        "disponible"
    ];
    protected $appends=[
        "ticket"
    ];
    public function evento(){
        return $this->belongsTo(eventos::class);
    }
    public function getTicketAttribute(){
        return ticket::where('puesto_id',$this->id)->first() ?? null;
    }

}
