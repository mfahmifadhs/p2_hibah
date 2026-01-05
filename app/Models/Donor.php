<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "donor";
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'nama_donor',
        'deskripsi'
    ];

    public function proyek()
    {
        return $this->hasMany(Proyek::class, 'donor_id');
    }
}
