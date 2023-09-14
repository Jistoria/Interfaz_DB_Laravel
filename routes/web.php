<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/ver-articulos',function(){
    return view('ver_articulos');
});
//rutas para usuario
Route::get('/login', [UserController::class, 'show'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/logout',[UserController::class,'logout'])->name('logout');

Route::get('/registro', [UserController::class, 'show_register'])->name('registro');
Route::post('/registro', [UserController::class, 'register'])->name('registro');

Route::get('/user', [UserController::class,'user'])->name('user');
Route::get('/index_user', [UserController::class,'index_user'])->name('index_user');
Route::get('ver_compra',[UserController::class,'index_vercompra'])->name('Ver_Compra');
Route::get('/invoice_user/{id}', [UserController::class,'invoice_user'])->name('invoice_user');

// Route::get('/user',[UserController::class, 'get_user'])->name('obtener_usuario');

//rutas para products
Route::get('/products',[ProductController::class,'index'])->name('products');
Route::get('/products_list',[ProductController::class,'products_list'])->name('products_list');
Route::post('/create_product',[ProductController::class,'store'])->name('create_product');
Route::put('/products/{id}', [ProductController::class, 'updateProduct'])->name('products.update');
Route::post('/add_to_cart',[ProductController::class, 'guardarProductos'])->name('agregar_product');
Route::post('/finalizar_compra/{id}/{imp}',[ProductController::class, 'facturacion'])->name('finalizar_compra');

 //ruta para usuarios admin
 Route::get('/admin-login',[AdminController::class,'index_login'])->name('admin-login');
 Route::get('/type_password',[AdminController::class,'type_index'])->name('type_password');
 Route::post('/type_password',[AdminController::class,'type_password'])->name('type_password');
 Route::post('/login-admin', [AdminController::class, 'login'])->name('login-admin');
 Route::get('/crear_admin', [AdminController::class, 'register_admin'])->name('crear_admin');
 Route::get('/get_admin', [AdminController::class, 'get_admin'])->name('get_admin');
 Route::get('/logout_admin',[AdminController::class,'logout'])->name('logout_admin');
 Route::get('/modify_products',[AdminController::class,'index'])->name('modify_product');
 Route::get('/create_product',[AdminController::class,'index'])->name('create_product');
 Route::get('/admin',[AdminController::class,'index'])->name('admin');
 Route::get('/getuser_all',[AdminController::class,'get_user_all'])->name('userall');


 //rutas para obtener marca, compo(Usan el controller de Productos)
 Route::get('/get_marca',[ProductController::class,'index_marca'])->name('get_marca');
 Route::get('/get_compo',[ProductController::class,'index_compo'])->name('get_compo');

 Route::get('/table_brand',[ProductController::class,'table_brand'])->name('table_brand');
 Route::get('/table_compo',[ProductController::class,'table_compo'])->name('table_compo');


 Route::post('/create_brand',[ProductController::class,'created_brand'])->name('create_brand');
 Route::post('/create_compo',[ProductController::class,'created_compo'])->name('create_compo');




 //rutas para factura (Usan el controller de Productos)
 Route::get('/get_methodop',[ProductController::class,'get_methodpago'])->name('get_metodop');
 Route::get('/getinvoice_all',[ProductController::class,'get_invoice_all'])->name('get_invoice_all');
 Route::get('/detalle_factura/{id}',[ProductController::class,'detalle_factura'])->name('detalle_factura');


