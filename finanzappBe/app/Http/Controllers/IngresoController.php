<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IngresoController extends Controller
{
    public function index()
    {
        $ingresos = Ingreso::where('id_usuario', Auth::id())->get();
        return response()->json($ingresos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'monto_ingreso' => 'required|numeric',
            'nombre' => 'required|string|max:255',
            'fecha' => 'required|date',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $ingreso = Ingreso::create([
            'id_usuario' => Auth::id(),
            'monto_ingreso' => $request->monto_ingreso,
            'nombre' => $request->nombre,
            'fecha' => $request->fecha,
            'descripcion' => $request->descripcion,
        ]);

        // Registrar un movimiento
        Movimiento::create([
            'id_usuario' => Auth::id(),
            'monto' => $request->monto_ingreso,
            'tipo' => 'ingreso',
            'categoria' => 'Ingreso',
            'fecha' => $request->fecha,
            'notas' => $request->nombre,
        ]);

        return response()->json($ingreso, 201);
    }

    public function show($id)
    {
        $ingreso = Ingreso::where('id_usuario', Auth::id())->where('id_ingreso', $id)->firstOrFail();
        return response()->json($ingreso);
    }

    public function destroy($id)
    {
        $ingreso = Ingreso::where('id_usuario', Auth::id())->where('id_ingreso', $id)->firstOrFail();
        $ingreso->delete();

        return response()->json(['message' => 'Ingreso eliminado correctamente.']);
    }
}
