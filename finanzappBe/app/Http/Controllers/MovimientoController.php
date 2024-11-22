<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimientoController extends Controller
{
    public function index()
    {
        $movimientos = Movimiento::where('id_usuario', Auth::id())->get();
        return response()->json($movimientos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric',
            'tipo' => 'required|in:ingreso,gasto',
            'categoria' => 'required|string|max:255',
            'fecha' => 'required|date',
            'notas' => 'nullable|string',
        ]);

        $movimiento = Movimiento::create([
            'id_usuario' => Auth::id(),
            'monto' => $request->monto,
            'tipo' => $request->tipo,
            'categoria' => $request->categoria,
            'fecha' => $request->fecha,
            'notas' => $request->notas,
        ]);

        return response()->json($movimiento, 201);
    }

    public function show($id)
    {
        $movimiento = Movimiento::where('id_usuario', Auth::id())->where('id_movimiento', $id)->firstOrFail();
        return response()->json($movimiento);
    }

    public function destroy($id)
    {
        $movimiento = Movimiento::where('id_usuario', Auth::id())->where('id_movimiento', $id)->firstOrFail();
        $movimiento->delete();

        return response()->json(['message' => 'Movimiento eliminado correctamente.']);
    }
}