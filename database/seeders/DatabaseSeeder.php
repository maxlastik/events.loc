<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Just some users
        User::factory(10)->create();

        // Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.ru',
            'password' => bcrypt('secret'),
            'role' => 1,
        ]);

        // Member
        User::factory()->create([
            'name' => 'Member User',
            'email' => 'member@member.ru',
            'password' => bcrypt('secret'),
            'role' => 2,
        ]);

        Category::factory(6)->create();

        Event::factory(50)->create();

        // Каждому событию добавим несколько случайных категорий
        $events = Event::all();
        foreach ($events as $event) {
            $event->categories()->attach(rand(1, 2));
            $event->categories()->attach(rand(3, 4));
            $event->categories()->attach(rand(5, 6));
        }

    }
}
