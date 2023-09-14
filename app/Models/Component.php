<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_component';
    public $timestamps = false;
    protected  $table = 'component';
    protected $fillable = [
        'compo_type',
        'compo_descrip',
    ];
    public function productos()
    {
     return $this->hasMany(Product::class, 'id_component');
    }
}
