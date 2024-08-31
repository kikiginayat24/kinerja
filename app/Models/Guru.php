<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = "tb_gtk";
    protected $primaryKey = "id_user";
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap',
        'pangkat',
        'jabatan',
    ];
}
