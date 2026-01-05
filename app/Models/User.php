<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    protected $table = "users";
    protected $primaryKey = "id";

    protected $fillable = [
        'id',
        'role_id',
        'pegawai_id',
        'username',
        'password',
        'password_text',
        'akses',
        'status',
        'deleted_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function donor()
    {
        return $this->belongsTo(Donor::class, 'uker_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'uker_id');
    }
}
