<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataKios extends Model
{
    use HasFactory;

    protected $table = 'data_kios';

    protected $guarded = [];

    /**
     * Relasi ke DataPasar (Many to One)
     */
    public function pasar(): BelongsTo
    {
        return $this->belongsTo(DataPasar::class, 'pasar_id');
    }
}
