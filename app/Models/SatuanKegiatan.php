<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SatuanKegiatan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "satuan_kegiatan";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'nama_satuan',
        'deskripsi'
    ];
}
