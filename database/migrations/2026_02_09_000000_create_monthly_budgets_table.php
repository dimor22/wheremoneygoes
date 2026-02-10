<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('monthly_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('household_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->date('budget_month');
            $table->decimal('amount', 10, 2)->default(0);
            $table->timestamps();

            $table->unique(['household_id', 'budget_month']);
        });

        $currentMonth = Carbon::now()->startOfMonth()->toDateString();

        $settings = DB::table('settings')
            ->whereNotNull('household_id')
            ->select('household_id', 'user_id', 'monthly_budget')
            ->get();

        foreach ($settings as $setting) {
            DB::table('monthly_budgets')->updateOrInsert(
                [
                    'household_id' => $setting->household_id,
                    'budget_month' => $currentMonth,
                ],
                [
                    'user_id' => $setting->user_id,
                    'amount' => $setting->monthly_budget,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_budgets');
    }
};
