<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MethodPago extends Model
{
    use HasFactory;
    protected $table ='payment_method';
    protected $primaryKey ='id_method';
    protected $fillabel = [
        'payment_type',
    ];
}
