<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyBudget extends Model
{
    protected $fillable = [
        'household_id',
        'user_id',
        'budget_month',
        'amount',
    ];

    protected $casts = [
        'budget_month' => 'date:Y-m-d',
        'amount' => 'decimal:2',
    ];

    public function household(): BelongsTo
    {
        return $this->belongsTo(Household::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
