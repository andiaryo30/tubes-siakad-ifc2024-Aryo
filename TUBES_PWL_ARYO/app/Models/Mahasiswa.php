<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = ['nim', 'nama', 'email', 'angkatan', 'kelas', 'no_hp', 'alamat'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function krs(): HasMany
    {
        return $this->hasMany(Krs::class);
    }
}
