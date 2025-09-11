<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AutenticacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function mostrarFormularioRegistro()
    {
        return view('auth.registrar');
    }

    public function mostrarFormularioLogin()
    {
        return view('auth.iniciar-sesion');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function registrarUsuario(Request $request)
    {
        // Validación de datos
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nombres.required' => 'El campo nombres es obligatorio.',
            'apellidos.required' => 'El campo apellidos es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ]);

        // Si la validación falla, redirigir con errores
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // Crear el usuario
        $user = User::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Autenticar al usuario después del registro
        Auth::login($user);

        // Redirigir al dashboard o página de inicio
        return redirect()->route('dashboard')
            ->with('success', '¡Registro exitoso! Bienvenido a PoultryNet.');
    }

    public function iniciarSesion(Request $request)
    {
        // Validación de campos
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6'],
        ], [
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'Debes ingresar un correo electrónico válido',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
        ]);

        // Intentar autenticar
        $credenciales = $request->only('email', 'password');
        $recordar = $request->filled('remember'); // checkbox

        if (Auth::attempt($credenciales, $recordar)) {
            // Regenerar sesión
            $request->session()->regenerate();

            // Guardar datos del usuario en sesión (por si necesitas)
            session([
                'usuario_id' => Auth::id(),
                'usuario_nombre' => Auth::user()->name, // cambia según tu tabla users
            ]);

            return redirect()->intended('dashboard')->with('status', 'Bienvenido de nuevo 👋');
        }

        // Si falla
        return back()->withErrors([
            'email' => 'Las credenciales no son válidas.',
        ])->withInput($request->only('email', 'remember'));
    }

    /**
     * Cerrar sesión.
     */
    public function cerrarSesion(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Sesión cerrada correctamente.');
    }
}
