<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    use HasFactory;

    protected $table = 'user_admin';
    protected $primaryKey = 'id_admin_user';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'id_admin_type',
    ];

    public function typeAdmin()
    {
        return $this->belongsTo(TypeAdmin::class, 'id_admin_type');
    }
}
