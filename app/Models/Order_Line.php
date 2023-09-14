<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Line extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_order_line';
    protected $table ='order_line';
    public $timestamps = false;
    protected $fillable = [
        'id_invoice' ,
        'id_product',
        'quantity',
        'price_unit',
        'price_total',
    ];
    public function invoice()
    {
        return $this->belongsTo(Factura::class, 'id_invoice');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

}
