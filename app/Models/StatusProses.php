<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StatusProses extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "status_proses";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'nama_status',
        'deskripsi'
    ];
}
