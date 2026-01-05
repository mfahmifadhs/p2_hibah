<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PencairanTimeline extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "pencairan_timeline";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'pencairan_id',
        'status',
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pencairan()
    {
        return $this->belongsTo(Pencairan::class, 'pencairan_id');
    }
}
