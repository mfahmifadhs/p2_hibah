<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimKerja extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "tim_kerja";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'uker_id',
        'tim_kerja'
    ];


    public function uker()
    {
        return $this->belongsTo(UnitKerja::class, 'uker_id');
    }
}
