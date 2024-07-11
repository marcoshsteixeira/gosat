<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cpf extends Model
{
    use HasFactory;

    protected $fillable = ['cpf'];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
