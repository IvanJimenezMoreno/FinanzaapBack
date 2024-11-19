<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresupuestoController extends Controller
{

    public function index()
    {
        $presupuestos = Presupuesto::where('id_usuario', Auth::id())->get();
        return response()->json($presupuestos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'monto_presupuesto' => 'required|numeric',
            'periodo' => 'required|date',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $presupuesto = Presupuesto::create([
            'id_usuario' => Auth::id(), // Obtiene el ID del usuario autenticado
            'monto_presupuesto' => $request->monto_presupuesto,
            'periodo' => $request->periodo,
            'descripcion' => $request->descripcion,
        ]);

        return response()->json($presupuesto, 201);
    }

    public function restar(Request $request, $id)
    {
        $request->validate([
            'monto' => 'required|numeric|min:0',
        ]);

        $presupuesto = Presupuesto::where('id_usuario', Auth::id())->where('id_presupuesto', $id)->firstOrFail();
        $presupuesto->monto_presupuesto -= $request->monto;
        $presupuesto->save();

        return response()->json($presupuesto);
    }

    public function destroy($id)
    {
        $presupuesto = Presupuesto::where('id_usuario', Auth::id())->where('id_presupuesto', $id)->firstOrFail();
        $presupuesto->delete();

        return response()->json(['message' => 'Presupuesto eliminado correctamente.']);
    }
}