<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pencairan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "pencairan";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'kegiatan_id',
        'perihal',
        'tanggal',
        'total',
        'keterangan',
        'lampiran',
        'status_1',
        'status_2'
    ];

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function timeline()
    {
        return $this->hasMany(PencairanTimeline::class, 'pencairan_id');
    }
}
