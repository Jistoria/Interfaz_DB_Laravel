<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistroRequest;
use App\Models\Factura;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function show_register(){
        if(Auth::check()){
            return redirect('/');
         }
        return view('auth.registro');
    }

    public function register(RegistroRequest $request){
        $user = User::create($request->validated());
        return response()->json(['user' => $user]);

        }
    public function show(){
        if(Auth::check() || Auth::guard('admin')->check()){
          return redirect('/');
        }
        return view('auth.login');
    }


    public function login(LoginRequest $request){
        try {
            $credentials = $request->getCredentials();

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                // Autenticación exitosa, devuelve una respuesta adecuada (por ejemplo, un token de acceso)
                return response()->json(['user' => $user]);

            } else {
                // Autenticación fallida, devuelve una respuesta de error (por ejemplo, credenciales inválidas)
                return response()->json(['message' => 'Credenciales inválidas'], 401);
            }
        } catch (ValidationException $e) {
            // Excepción de validación, devuelve una respuesta de error 422 con un mensaje único
            return response()->json(['message' => 'Error de validación'], 422);
        } catch (\Exception $e) {
            // Excepción no controlada, devuelve una respuesta de error 500 con un mensaje personalizado
            return response()->json(['message' => 'Ocurrió un error interno'], 500);
        }


    }

    public function authenticated(Request $request, $user){
        return redirect()->route('/');
    }

    public function user(Request $request)
    {
        if(Auth::user()){
            $user = Auth::user();
            return  $user;
        }
        $user= null;
        return $user;
    }
    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
    public function index_vercompra(){
        return view('auth.ver_compra');
    }
    public function index_user(){
        return view('welcome');
    }

    public function invoice_user ($id){
        $invoice = Factura::WHERE('id_user',$id)->get();
        return $invoice;
    }
}
