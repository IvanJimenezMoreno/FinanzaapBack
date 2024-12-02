<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    public function index()
    {
        $usuarios = Usuarios::all();
        return response()->json($usuarios);
    }

    public function show($id)
    {
        $usuario = Usuarios::findOrFail($id);
        return response()->json($usuario);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:usuarios',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'password' => 'required|string|min:8|confirmed',
            'is_admin' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $usuario = Usuarios::create([
            'nombre' => $request->nombre,
            'nombre_usuario' => $request->nombre_usuario,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => $request->is_admin ?? false,
        ]);

        return response()->json($usuario, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:255',
            'nombre_usuario' => 'sometimes|required|string|max:255|unique:usuarios,nombre_usuario,' . $id,
            'email' => 'sometimes|required|string|email|max:255|unique:usuarios,email,' . $id,
            'is_admin' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $usuario = Usuarios::findOrFail($id);
        $usuario->update([
            'nombre' => $request->nombre ?? $usuario->nombre,
            'nombre_usuario' => $request->nombre_usuario ?? $usuario->nombre_usuario,
            'email' => $request->email ?? $usuario->email,
            'is_admin' => $request->is_admin ?? $usuario->is_admin,
        ]);

        return response()->json($usuario);
    }

    public function destroy($id)
    {
        $usuario = Usuarios::findOrFail($id);
        $usuario->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente.']);
    }

    public function buscarPorNombre($nombre)
    {
        $usuarios = Usuarios::where('nombre', 'like', '%' . $nombre . '%')->get();
        if ($usuarios->isEmpty()) {
            return response()->json(['message' => 'No existe ningún usuario con ese nombre.'], 404);
        }

        return response()->json($usuarios);
    }
}
