<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Modalities extends Model
{
    use HasFactory;

    protected $fillable = ['institutions_id', 'name', 'code', 'minPortion', 'maxPortion', 'minValue', 'maxValue', 'fess'];

    /**
     * Get the institution.
     */
    public function institutions(): BelongsTo
    {
        return $this->belongsTo(Institutions::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
