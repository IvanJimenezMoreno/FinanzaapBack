<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    protected $table = 'presupuesto';

    protected $primaryKey = 'id_presupuesto';

    protected $fillable = [
        'id_usuario',
        'monto_presupuesto',
        'periodo',
        'descripcion',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario');
    }
}