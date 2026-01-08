<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Store;
use App\Models\Household;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first household (Dev Household)
        $household = Household::first();

        if (!$household) {
            return;
        }

        // Create 7 categories
        $categories = [
            'Groceries',
            'Restaurants',
            'Transportation',
            'Entertainment',
            'Utilities',
            'Healthcare',
            'Shopping',
        ];

        foreach ($categories as $categoryName) {
            Category::create([
                'household_id' => $household->id,
                'user_id' => $household->users()->first()->id,
                'name' => $categoryName,
            ]);
        }

        // Create 7 stores
        $stores = [
            'Walmart',
            'Target',
            'Amazon',
            'Costco',
            'Whole Foods',
            'CVS',
            'Gas Station',
        ];

        foreach ($stores as $storeName) {
            Store::create([
                'household_id' => $household->id,
                'user_id' => $household->users()->first()->id,
                'name' => $storeName,
            ]);
        }
    }
}
