<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_product';
    public $timestamps = false;
    protected $table = 'products';
    protected $fillable = [
        'product_name',
        'description_product',
        'image',
        'price',
        'quantity',
        'id_product_brand',
        'id_component',
    ];

    public function product_brand()
    {
        return $this->belongsTo(Marca::class, 'id_product_brand');
    }

    public function component()
    {
        return $this->belongsTo(Component::class, 'id_component');
    }
}
