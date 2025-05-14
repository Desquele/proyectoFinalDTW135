<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    // Definiendo los campos que se pueden insertar/actualizar
    protected $fillable = [
        'titulo',
        'descripcion',
        'usuario_id',
        'estado',
    ];

    // Relación con el modelo usuario
    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'usuario_id');
    }
}
