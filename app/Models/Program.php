<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "program";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'uker_id',
        'nama_program',
        'keterangan'
    ];

    public function uker()
    {
        return $this->belongsTo(UnitKerja::class, 'uker_id');
    }

    public function pengadaan()
    {
        return $this->hasMany(Pengadaan::class, 'program_id');
    }
}
