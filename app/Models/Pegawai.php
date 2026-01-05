<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "pegawai";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'uker_id',
        'timker_id',
        'jabatan_id',
        'nama',
        'nip',
        'jenis_kelamin',
        'no_telepon',
        'email'
    ];

    public function uker()
    {
        return $this->belongsTo(UnitKerja::class, 'uker_id');
    }

    public function timker()
    {
        return $this->belongsTo(TimKerja::class, 'timker_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}
