<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@devlog.test'],
            [
                'name' => 'DevLog Admin',
                'password' => 'password',
            ],
        );

        $this->call(PostSeeder::class);
    }
}
