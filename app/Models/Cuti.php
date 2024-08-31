<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;
    protected $table = "tb_cuti";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'tgl_awal',
        'tgl_akhir',
        'status_approved'
    ];
}
