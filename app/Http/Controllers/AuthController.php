<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VendorProfile;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostrar vista de Inicio de Sesión (Ventana 2)
    public function showLogin()
    {
        return view('auth.login');
    }

    //procesar inicio de sesion
    public function processLogin(Request $request)
    {
        //validar datos
        $credentials= $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        //intentar autenticar al usuario
        if (Auth::attempt($credentials, $request->remember)){
            $request->session()->regenerate();

        //redireccionar al inicio con mensaje de bienvenida
            return redirect()->intended('/')->with('success', '¡Bienvenido de nuevo a BENEXPRESS!');
        }
        //si las credenciales fallan
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden.',
        ])->onlyInput('email');

    }
//Cerrar sesion
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }






    // Mostrar vista de Registro (Ventanas 3 y 4)
    public function showRegister()
    {
        // Traer categorías de tipo 'tienda' para el formulario de proveedor
        $categories = Category::where('type', 'tienda')->get();
        return view('auth.register', compact('categories'));
    }

    // Procesar Registro
    public function processRegister(Request $request)
    {
        // Validación según el tipo de rol
        $request->validate([
            'role' => 'required|in:cliente,proveedor',
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|int|max:10',
            'password' => 'required|min:6|confirmed',
            'ine_image' => 'required|image|max:5120', // Máx 5MB
        ]);

        // Manejo de la subida de INE
        $inePath = null;
        if ($request->hasFile('ine_image')) {
            $inePath = $request->file('ine_image')->store('ines', 'public');
        }

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'ine_image_path' => $inePath,
        ]);

        // Si se registró como Proveedor (Ventana 4)
        if ($request->role === 'proveedor') {
            $request->validate([
                'store_name' => 'required|string|max:120',
                'category_id' => 'required|exists:categories,id',
                'clabe' => 'required|digits:18',
            ]);

            VendorProfile::create([
                'user_id' => $user->id,
                'store_name' => $request->store_name,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'clabe' => $request->clabe,
                'status' => 'pendiente',
            ]);
        }

        return redirect()->route('login')->with('success', 'Cuenta creada exitosamente. Inicia sesión para continuar.');
    }
}