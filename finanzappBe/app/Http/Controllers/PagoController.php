<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Movimiento;
use App\Notifications\PagoRecordatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::where('id_usuario', Auth::id())->get();
        return response()->json($pagos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_pago' => 'required|string|max:255',
            'fecha_pago' => 'required|date',
            'monto_pago' => 'required|numeric',
            'estado_pago' => 'required|boolean',
            'recordatorio_activado' => 'required|boolean',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $pago = Pago::create([
            'id_usuario' => Auth::id(),
            'nombre_pago' => $request->nombre_pago,
            'fecha_pago' => $request->fecha_pago,
            'monto_pago' => $request->monto_pago,
            'estado_pago' => $request->estado_pago,
            'recordatorio_activado' => $request->recordatorio_activado,
            'descripcion' => $request->descripcion,
        ]);

        // Si el estado del pago es pagado, registrar un movimiento
        if ($pago->estado_pago) {
            Movimiento::create([
                'id_usuario' => Auth::id(),
                'monto' => $request->monto_pago,
                'tipo' => 'gasto',
                'categoria' => 'Pago',
                'fecha' => Carbon::now(), // Usar la fecha actual
                'notas' => $request->nombre_pago,
            ]);
        }

        // Programar el envío del correo electrónico de recordatorio
        if ($pago->recordatorio_activado) {
            $fechaRecordatorio = $pago->fecha_pago->subWeek();
            $pago->usuario->notify((new PagoRecordatorio($pago))->delay($fechaRecordatorio));
        }

        return response()->json($pago, 201);
    }

    public function show($id)
    {
        $pago = Pago::where('id_usuario', Auth::id())->where('id_pago', $id)->firstOrFail();
        return response()->json($pago);
    }

    public function destroy($id)
    {
        $pago = Pago::where('id_usuario', Auth::id())->where('id_pago', $id)->firstOrFail();
        $pago->delete();

        return response()->json(['message' => 'Pago eliminado correctamente.']);
    }

    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado_pago' => 'required|boolean',
        ]);

        $pago = Pago::where('id_usuario', Auth::id())->where('id_pago', $id)->firstOrFail();
        $pago->estado_pago = $request->estado_pago;
        $pago->save();

        // Si el estado del pago se cambia a pagado, registrar un movimiento
        if ($pago->estado_pago) {
            Movimiento::create([
                'id_usuario' => Auth::id(),
                'monto' => $pago->monto_pago,
                'tipo' => 'gasto',
                'categoria' => 'Pago',
                'fecha' => Carbon::now(), // Usar la fecha actual
                'notas' => $pago->nombre_pago,
            ]);
        }

        return response()->json($pago);
    }
}