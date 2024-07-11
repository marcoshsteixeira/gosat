<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    public function institutions(): BelongsTo
    {
        return $this->belongsTo(Institutions::class);
    }

    public function modalities(): BelongsTo
    {
        return $this->belongsTo(Modalities::class);
    }

    public function cpf(): BelongsTo
    {
        return $this->belongsTo(Cpf::class);
    }
}
