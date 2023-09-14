<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Http\Requests\TypeAdminRequest;
use App\Models\AdminUser;
use App\Models\Factura;
use App\Models\TypeAdmin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function index () {
        return view('auth.admin.admin');
    }
    public function index_login(){
        return view('auth.admin.login-admin');
    }
    public function type_index () {
        return view('auth.admin.type-admin');
    }

    public function type_password(TypeAdminRequest $request){
        $password = $request->getCredentials();
         // Verificar la contraseña en la tabla TypeAdmin
    $typeAdmin = TypeAdmin::where('password_rol', $password)->first();

    if ($typeAdmin) {
        // Contraseña válida, hacer algo aquí

        return response()->json([
            'success' => true,
            'message' => 'Contraseña válida',
            'type_admin' => $typeAdmin
        ]);
    } else {
        // Contraseña incorrecta
        return response()->json([
            'success' => false,
            'message' => 'Contraseña incorrecta'
        ]);
    }
    }

    public function login(AdminRequest $request)
    {
        $credentials = $request->only('username', 'password');


    if (Auth::guard('admin')->attempt($credentials)) {
        // El inicio de sesión fue exitoso

        $user = Auth::guard('admin')->user(); // Obtener los datos del usuario autenticado

        return response()->json([
            'success' => true,
            'message' => 'Inicio de sesión exitoso',
            'user' => $user, // Incluir los datos del usuario en la respuesta
        ]);
    } else {
        // Contraseña incorrecta
        return response()->json([
            'success' => false,
            'message' => 'Credenciales Invalidas'
        ]);
    }
    }




    //obtener admin
    public function get_admin()
    {
        if (Auth::guard('admin')->check()) {
            $admin = AdminUser::with('typeAdmin')->find(Auth::guard('admin')->id());  // Obtener los datos del administrador autenticado
            return response()->json(['admin' => $admin]);
        }

        // No se encontró ningún administrador autenticado, devuelve un valor nulo
        $admin = null;
        return response()->json(['admin' => $admin]);
    }
    public function logout()
{
    Auth::guard('admin')->logout();
    return redirect('/admin-login');
}


//Funcione de crear admin (no hare un formulario :) )
    public function register_admin(){
        AdminUser::create([
            'username' => 'diego',
            'password' => bcrypt('hola'),
            'id_admin_type' => 1,
        ]);
    }

//obtener todos los user
public function get_user_all(){
    $users = User::get();
    return $users;
}

}
