<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisHibah extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "jenis_hibah";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'nama_jenis',
        'deskripsi'
    ];
}
