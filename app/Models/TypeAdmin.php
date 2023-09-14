<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAdmin extends Model
{
    use HasFactory;
    protected $table = 'type_admin';
    protected $primaryKey = 'id_admin_type';
    public $timestamps = false;

    protected $fillable = [
        'user_rol',
        'password_rol',
    ];
}
