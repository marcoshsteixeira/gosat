<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Institutions extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function modalities(): HasMany
    {
        return $this->hasMany(Modalities::class);
    }
}
