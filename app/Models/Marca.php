<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $table='product_brand';
    protected $fillable = [
        'name_product_brand',
        'descrip',

    ];
    public $timestamps = false;
   protected $primaryKey = 'id_product_brand';
   public function productos()
   {
    return $this->hasMany(Product::class, 'id_product_brand');
   }
}
