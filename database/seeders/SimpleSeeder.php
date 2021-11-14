<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Issue;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class SimpleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->has(
                Issue::factory()
                    ->for(User::factory(), 'assignee')
                    ->has(
                        Comment::factory()
                            ->for(User::factory(), 'author')
                            ->count(3)
                    )
                    ->count(5)
            )
            ->count(10)
            ->create();
    }
}
