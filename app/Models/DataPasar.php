<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataPasar extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Relasi ke DataKios (One to Many)
     */
    public function kios(): HasMany
    {
        return $this->hasMany(DataKios::class, 'pasar_id');
    }

    /**
     * Relasi ke DataLos (One to Many)
     */
    public function los(): HasMany
    {
        return $this->hasMany(DataLos::class, 'pasar_id');
    }

    /**
     * Relasi ke DataLos (One to Many)
     */
    public function pelataran(): HasMany
    {
        return $this->hasMany(DataPelataran::class, 'pasar_id');
    }
}
