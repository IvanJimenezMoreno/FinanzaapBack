<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    use HasFactory;

    protected $table = 'ingresos';

    protected $primaryKey = 'id_ingreso';

    protected $fillable = [
        'id_usuario',
        'monto_ingreso',
        'nombre',
        'fecha',
        'descripcion',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
