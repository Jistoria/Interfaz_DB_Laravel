<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'invoice';
    protected $primaryKey = 'id_invoice';
    protected $fillable = [
        'id_user',
        'created_at',
        'id_method',
        'amount_total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function paymentMethod()
    {
        return $this->belongsTo(MethodPago::class, 'id_method');
    }
    public function orderLines()
    {
        return $this->hasMany(Order_Line::class, 'id_invoice');
    }

}
