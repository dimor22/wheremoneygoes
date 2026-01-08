<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Household;
use App\Models\Category;
use App\Models\Store;
use App\Models\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create a household for each existing user
        $users = User::all();
        
        foreach ($users as $user) {
            // Create household for user
            $household = Household::create([
                'name' => $user->name . "'s Household",
                'share_code' => Household::generateShareCode(),
            ]);

            // Assign user to household
            $user->update(['household_id' => $household->id]);

            // Move user's categories to household
            Category::where('user_id', $user->id)->update(['household_id' => $household->id]);

            // Move user's stores to household
            Store::where('user_id', $user->id)->update(['household_id' => $household->id]);

            // Move user's settings to household
            Setting::where('user_id', $user->id)->update(['household_id' => $household->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove household relationships
        User::query()->update(['household_id' => null]);
        Category::query()->update(['household_id' => null]);
        Store::query()->update(['household_id' => null]);
        Setting::query()->update(['household_id' => null]);
        
        // Delete all households
        Household::query()->delete();
    }
};
