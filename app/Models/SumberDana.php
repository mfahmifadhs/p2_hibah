<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SumberDana extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "sumber_dana";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'nama_sumber',
        'deskripsi'
    ];
}
