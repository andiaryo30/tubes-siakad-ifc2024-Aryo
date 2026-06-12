<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = ['nidn', 'nama', 'email', 'no_hp', 'alamat'];

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }
}
