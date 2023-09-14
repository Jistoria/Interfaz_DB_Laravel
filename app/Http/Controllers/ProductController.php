<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Component;
use App\Models\Factura;
use App\Models\Marca;
use App\Models\MethodPago;
use App\Models\Order_Line;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public function index()
    {
        // Obtener todos los productos
        $products = Product::with('product_brand', 'component')->paginate(4);// Acceder a la marca asociada al producto
        if($products){
            return $products;
        }
        $products =null;
        return $products;
    }
    public function products_list()
    {
        // Obtener todos los productos con las relaciones 'marca' y 'component'
        $products = Product::with('product_brand', 'component')->get();

        if ($products) {
            return response()->json(['products' => $products]);
        }

        return null;
    }
    public function create()
    {
        // Mostrar el formulario de creación de productos
        return view('products.create');
    }
    public function store(ProductRequest $request)
    {
        // Crear un nuevo producto con los datos del formulario
        Product::create($request->validated());

        // Redireccionar o mostrar un mensaje de éxito
       return $request;
    }
    public function updateProduct(ProductRequest $request, $id)
    {
            // Obtener el producto existente
            $product = Product::findOrFail($id);

            // Actualizar los campos del producto con los datos del request
            $product->product_name = $request->input('product_name');
            $product->description_product = $request->input('description_product');
            $product->price = $request->input('price');
            $product->id_product_brand = $request->input('id_product_brand');
            $product->id_component = $request->input('id_component');
            $product->quantity = $request->input('quantity');

            // Guardar los cambios en la base de datos
            $product->save();

            // Retornar una respuesta exitosa
            return response()->json(['message' => 'Producto actualizado exitosamente', 'product' => $product]);
    }





//RELACIONES DE PRODUCT Y FACTURA

public function index_marca()
{
    $product_brand = Marca::get();
    return $product_brand;
}
    public function created_brand(Request $request){
         $new_brand = Marca::create($request->all());
        return response()->json(['message' => 'Marca creada exitosamente', 'new_brand' => $new_brand]);
    }
    public function table_brand(){
        $product_brand = Marca::with(['productos' => function ($query) {
            $query->select('id_product_brand', DB::raw("string_agg(product_name, ',') as product_names"))
                ->groupBy('id_product_brand');
        }])
        ->select('id_product_brand', 'name_product_brand', 'descrip')
        ->get();
        return $product_brand;
    }
    //Components
    public function index_compo(){
        $componente = Component::get();
        return $componente;
    }
    public function table_compo(){
        $component = Component::with(['productos' => function ($query) {
            $query->select('id_component', DB::raw("string_agg(product_name, ',') as product_names"))
                ->groupBy('id_component');
        }])
        ->select('id_component', 'compo_type', 'compo_descrip')
        ->get();
        return $component;
    }
    public function created_compo( Request $request){
        $new_compo = Component::create($request->all());
        return response()->json(['message' => 'Componente creado exitosamente', 'new_compo' => $new_compo]);
    }
    //metodo de pago
    public function get_methodpago(){
        $methodp = MethodPago::get();
        return $methodp;
    }
    //obtener todas las facturas
    public function get_invoice_all (){
        $invoice = Factura::with('user', 'paymentMethod')->get();
        return $invoice;
    }
    public function calcular_amount_total($products) {
        $total = 0;
        foreach ($products as $product) {
            $cantidad = $product['count'];
            $precioUnitario = $product['price'];
            $total += $cantidad * $precioUnitario;
        }
        return $total;
    }
    public function detalle_factura($id){
        $factura = Factura::with('user', 'paymentMethod', 'orderLines.product')->find($id);
        return $factura;
    }

//FACTURACION MATENME
    public function facturacion(Request $request, $id, $ipm){
        $products = $request->all();
        $amount_total = $this -> calcular_amount_total($products);
        $factura = new Factura();
        $factura->fill([
            'id_user'=> $id,
            'id_method' => $ipm,
            'amount_total' => $amount_total,
        ]);
        $factura ->saveOrFail();
        $idFactura = $factura -> id_invoice;

           // Recorrer carrito de compras
    // Recorrer carrito de compras
    foreach ($products as $product) {
        // El producto que se vende...
        $productoVendido = new Order_Line();
        $productoVendido->fill([
            "id_invoice" => $idFactura,
            "id_product" => $product['id_product'],
            "quantity" => $product['count'],
            "price_unit" => $product['price'],
            "price_total" =>  $product['count'] * $product['price'],
        ]);
        $productoVendido->saveOrFail();
        $productoActualizado = Product::find($product['id_product']);
        $productoActualizado->quantity -= $productoVendido->quantity;
        $productoActualizado->saveOrFail();
    }

        return response()->json(['message' => 'Vamos q se hace la factura', 'product' => $products,
        'id_user'=> $id,
        'ipm' => $idFactura
    ]);

    }



}
