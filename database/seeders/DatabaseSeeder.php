<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // 1️⃣ Seed 10 users
        $users = User::factory()->count(10)->create();

        // 2️⃣ Seed 5 main categories
        $mainCategories = Category::factory()->count(5)->create();

        // 3️⃣ Seed 2 subcategories per main category
        $subCategories = collect();

        foreach ($mainCategories as $mainCategory) {
            $subs = Category::factory()
                ->count(2)
                ->subCategory($mainCategory)
                ->create();

            $subCategories = $subCategories->merge($subs);
        }

        // 4️⃣ Seed 10 products per user
        $users->each(function ($user) use ($subCategories) {
            Product::factory()
                ->count(10)
                ->create([
                    'user_id' => $user->id,
                    'category_id' => $subCategories->random()->id,
                ]);
        });

        // User::factory()
        //     ->count(10)
        //     ->hasProducts(10)
        //     ->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
