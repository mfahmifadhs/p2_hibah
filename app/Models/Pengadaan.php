<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengadaan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "pengadaan";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'program_id',
        'kode',
        'nama'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function dana()
    {
        return $this->hasMany(PengadaanDana::class, 'pengadaan_id');
    }
}
