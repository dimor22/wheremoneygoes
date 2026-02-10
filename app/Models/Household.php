<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Household extends Model
{
    protected $fillable = [
        'name',
        'share_code',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }

    public function setting()
    {
        return $this->hasOne(Setting::class);
    }

    public function monthlyBudgets(): HasMany
    {
        return $this->hasMany(MonthlyBudget::class);
    }

    public function budgetForMonth(Carbon $date): float
    {
        $monthStart = $date->copy()->startOfMonth()->toDateString();

        $budget = $this->monthlyBudgets()
            ->whereDate('budget_month', '<=', $monthStart)
            ->orderBy('budget_month', 'desc')
            ->value('amount');

        if ($budget === null) {
            $budget = $this->setting?->monthly_budget ?? 0;
        }

        return (float) $budget;
    }

    public function budgetForExactMonth(Carbon $date): float
    {
        $monthStart = $date->copy()->startOfMonth()->toDateString();

        $budget = $this->monthlyBudgets()
            ->whereDate('budget_month', $monthStart)
            ->value('amount');

        return (float) ($budget ?? 0);
    }

    public static function generateShareCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (self::where('share_code', $code)->exists());

        return $code;
    }

    public static function findByShareCode(string $code): ?self
    {
        return self::where('share_code', $code)->first();
    }
}
