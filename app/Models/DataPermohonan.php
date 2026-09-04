<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataPermohonan extends Model
{
    protected $table = 'data_permohonans';

    protected $guarded = [];

    /**
     * Relasi ke User (Pedagang)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke DataPasar
     */
    public function pasar(): BelongsTo
    {
        return $this->belongsTo(DataPasar::class, 'pasar_id');
    }
}
