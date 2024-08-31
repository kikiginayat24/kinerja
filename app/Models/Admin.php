<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $table = "users";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'akses',
        'password'
    ];
}
