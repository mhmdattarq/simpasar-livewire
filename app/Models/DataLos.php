<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataLos extends Model
{
    protected $table = 'data_los';

    protected $guarded = [];

    /**
     * Relasi ke DataPasar (Many to One)
     */
    public function pasar(): BelongsTo
    {
        return $this->belongsTo(DataPasar::class, 'pasar_id');
    }
}
