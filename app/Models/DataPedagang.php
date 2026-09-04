<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataPedagang extends Model
{
    protected $table = 'data_pedagangs';

    protected $guarded = [];

    /**
     * Relasi ke User (Many to One / BelongsTo)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
