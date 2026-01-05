<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KegiatanTimeline extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "kegiatan_timeline";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'kegiatan_id',
        'status',
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }
}
